<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PageConfiguration;
use App\Models\User;

class PageConfigurationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageConfiguration $pageConfiguration): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageConfiguration $pageConfiguration): bool
    {
        return $user->isAdmin();
    }
}
