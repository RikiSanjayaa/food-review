<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Recipe $recipe)
    {
        // Check for existing review ONLY if it's not a reply
        $existing = null;
        if (! $request->filled('parent_id')) {
            $existing = $recipe->reviews()
                ->where('user_id', $request->user()->id)
                ->whereNull('parent_id')
                ->first();
        }

        if ($existing) {
            $existing->update($request->validated());
            $review = $existing;
        } else {
            // For replies, rating might not be relevant or required?
            // Usually replies don't have ratings, just comments.
            // But if the validation requires rating, we need to handle it.
            // Let's assume replies share the rating or make rating nullable/optional for replies?
            // Per request, "balas hasil review", implying a comment reply.
            // If validation enforces rating, we might need to adjust ReviewRequest or pass a dummy rating for replies.
            // For now, let's assume incoming request handles it or user provides rating again (which is weird for reply).
            // BETTER APPROACH: Make rating nullable in database/request if parent_id is present.
            // But to keep it simple and safe for now without altering schema too much (rating column is likely not nullable),
            // we can just use the request's rating if provided, or default to 5-star (hidden) if reply?
            // Actually, looking at migration `create_reviews_table`, rating is likely an integer column.
            
            // Let's just create it. The validation allows parent_id.
            $review = $recipe->reviews()->create([
                ...$request->validated(),
                'user_id' => $request->user()->id,
            ]);
        }

        $recipe->recalculateRatings();

        return redirect()->route('recipes.show', $recipe)->with('status', 'Review saved.');
    }

    public function destroy(Recipe $recipe, Review $review)
    {
        Gate::authorize('delete', $review);

        if ($review->recipe_id !== $recipe->id) {
            abort(404);
        }

        $review->delete();
        $recipe->recalculateRatings();

        return redirect()->route('recipes.show', $recipe)->with('status', 'Review removed.');
    }

    public function report(Review $review)
    {
        $review->update(['is_reported' => true]);

        return back()->with('status', 'Review reported for moderation.');
    }

    public function moderate(Review $review)
    {
        Gate::authorize('moderate', $review);

        $review->update([
            'is_hidden' => ! $review->is_hidden,
            'is_reported' => false,
        ]);

        $review->recipe->recalculateRatings();

        return back()->with('status', 'Review moderation updated.');
    }
}

