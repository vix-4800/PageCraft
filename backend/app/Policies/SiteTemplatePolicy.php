<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SiteTemplate;
use App\Models\User;

class SiteTemplatePolicy
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
    public function view(User $user, SiteTemplate $siteTemplate): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SiteTemplate $siteTemplate): bool
    {
        return $user->isAdmin();
    }
}
