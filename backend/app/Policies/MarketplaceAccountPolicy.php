<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\MarketplaceAccount;
use App\Models\User;

class MarketplaceAccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MarketplaceAccount $marketplaceAccount): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MarketplaceAccount $marketplaceAccount): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MarketplaceAccount $marketplaceAccount): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MarketplaceAccount $marketplaceAccount): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MarketplaceAccount $marketplaceAccount): bool
    {
        return $this->viewAny($user);
    }
}
