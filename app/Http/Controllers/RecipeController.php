<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'q' => $request->string('q')->toString(),
            'tags' => $request->collect('tags')->filter()->map(fn($id) => (int) $id)->all(),
            'diet' => $request->string('diet')->toString(),
            'time_min' => $request->integer('time_min'),
            'time_max' => $request->integer('time_max'),
            'sort' => $request->string('sort')->toString(),
        ];

        $query = Recipe::query()
            ->with(['tags', 'user', 'images'])
            ->withCount([
                'reviews as visible_reviews_count' => fn($q) => $q->where('is_hidden', false),
            ]);

        if ($filters['q']) {
            $query->where(function ($q) use ($filters): void {
                $q->where('title', 'like', '%' . $filters['q'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['q'] . '%')
                    ->orWhere('ingredients', 'like', '%' . $filters['q'] . '%');
            });
        }

        if (!empty($filters['tags'])) {
            $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $filters['tags']));
        }

        if ($filters['diet']) {
            $query->where('diet', $filters['diet']);
        }

        if ($filters['time_min']) {
            $query->whereRaw('(COALESCE(prep_time, 0) + COALESCE(cook_time, 0)) >= ?', [$filters['time_min']]);
        }

        if ($filters['time_max']) {
            $query->whereRaw('(COALESCE(prep_time, 0) + COALESCE(cook_time, 0)) <= ?', [$filters['time_max']]);
        }

        $sort = $filters['sort'] ?: 'newest';
        match ($sort) {
            'rating' => $query->orderByDesc('rating_avg'),
            'time' => $query->orderByRaw('COALESCE(prep_time, 0) + COALESCE(cook_time, 0) asc'),
            default => $query->latest('published_at')->latest(),
        };

        $recipes = $query->paginate(8)->withQueryString();
        $tags = Tag::orderBy('name')->get();

        // Get top 5 recipes with most ratings for carousel
        $topRatedRecipes = Recipe::where('rating_count', '>', 0)
            ->orderByDesc('rating_count')
            ->limit(5)
            ->get();

        $diets = [
            'vegan' => 'Vegan',
            'vegetarian' => 'Vegetarian',
            'gluten-free' => 'Bebas Gluten',
            'halal' => 'Halal',
        ];

        if ($request->ajax()) {
            return view('recipes._recipe_list', compact('recipes'))->render();
        }

        return view('recipes.index', compact('recipes', 'tags', 'filters', 'sort', 'topRatedRecipes', 'diets'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();

        return view('recipes.create', [
            'recipe' => new Recipe(),
            'tags' => $tags,
        ]);
    }

    public function store(RecipeRequest $request)
    {
        $data = $request->validated();

        $recipe = new Recipe($data);
        $recipe->user_id = $request->user()->id;
        $recipe->slug = $this->generateSlug($data['title']);
        $recipe->hero_image = $this->handleHeroImageUpload($request);
        $recipe->published_at = now();
        $recipe->save();

        $recipe->tags()->sync($request->input('tags', []));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('recipes/gallery', 'public');
                $recipe->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('recipes.show', $recipe)->with('status', 'Recipe published.');
    }

    public function show(Request $request, Recipe $recipe)
    {
        $recipe->load(['tags', 'user']);
        $user = $request->user();

        $reviews = $recipe->reviews()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id') // Only top-level reviews
            ->when(!$user || !$user->is_admin, fn($q) => $q->where('is_hidden', false))
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return view('reviews._list', compact('recipe', 'reviews'))->render();
        }

        return view('recipes.show', compact('recipe', 'reviews'));
    }

    public function edit(Recipe $recipe)
    {
        Gate::authorize('update', $recipe);

        $tags = Tag::orderBy('name')->get();

        return view('recipes.edit', compact('recipe', 'tags'));
    }

    public function update(RecipeRequest $request, Recipe $recipe)
    {
        Gate::authorize('update', $recipe);

        $data = $request->validated();
        $data['slug'] = $this->generateSlug($data['title'], $recipe->id);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $this->handleHeroImageUpload($request, $recipe->hero_image);
        }

        $recipe->update($data);
        $recipe->tags()->sync($request->input('tags', []));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('recipes/gallery', 'public');
                $recipe->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('recipes.show', $recipe)->with('status', 'Recipe updated.');
    }

    public function destroy(Recipe $recipe)
    {
        Gate::authorize('delete', $recipe);

        if ($recipe->hero_image) {
            Storage::disk('public')->delete($recipe->hero_image);
        }

        foreach ($recipe->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('status', 'Recipe removed.');
    }

    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $i = 1;

        while (
            Recipe::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function handleHeroImageUpload(Request $request, ?string $existingPath = null): ?string
    {
        if (!$request->hasFile('hero_image')) {
            return $existingPath;
        }

        if ($existingPath) {
            Storage::disk('public')->delete($existingPath);
        }

        return $request->file('hero_image')->store('recipes', 'public');
    }
}
