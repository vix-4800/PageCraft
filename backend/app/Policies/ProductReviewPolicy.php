<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ProductReview;
use App\Models\User;

class ProductReviewPolicy
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
    public function view(User $user, ProductReview $productReview): bool
    {
        return $user->isAdmin() || $user->is($productReview->user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductReview $productReview): bool
    {
        return $user->is($productReview->user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductReview $productReview): bool
    {
        return $this->update($user, $productReview);
    }
}
