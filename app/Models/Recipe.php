<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'ingredients',
        'steps',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'diet',
        'cuisine',
        'hero_image',
        'rating_avg',
        'rating_count',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'rating_avg' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(RecipeImage::class);
    }

    public function totalTime(): ?int
    {
        if ($this->prep_time === null && $this->cook_time === null) {
            return null;
        }

        return (int) ($this->prep_time ?? 0) + (int) ($this->cook_time ?? 0);
    }

    public function recalculateRatings(): void
    {
        $reviews = $this->reviews()
            ->where('is_hidden', false)
            ->whereNull('parent_id') // Only top-level reviews count for rating
            ->get();

        $avg = $reviews->avg('rating');
        $count = $reviews->count();

        $this->update([
            'rating_avg' => round((float) ($avg ?? 0), 2),
            'rating_count' => (int) ($count ?? 0),
        ]);
    }
}

