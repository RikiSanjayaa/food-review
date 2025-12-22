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
        $existing = $recipe->reviews()
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existing) {
            $existing->update($request->validated());
            $review = $existing;
        } else {
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

