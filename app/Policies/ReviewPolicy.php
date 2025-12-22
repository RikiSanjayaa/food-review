<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function delete(User $user, Review $review): bool
    {
        return $user->is_admin || $review->user_id === $user->id;
    }

    public function moderate(User $user, Review $review): bool
    {
        return $user->is_admin;
    }
}

