<?php

namespace App\Policies;

use App\Models\ProductReviewReaction;
use App\Models\User;
use Auth;

class ProductReviewReactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductReviewReaction $productReviewReaction): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductReviewReaction $productReviewReaction): bool
    {
        return $user->is($productReviewReaction->user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductReviewReaction $productReviewReaction): bool
    {
        return $this->update($user, $productReviewReaction);
    }
}
