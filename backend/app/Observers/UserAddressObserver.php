<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\UserAddress;

class UserAddressObserver
{
    /**
     * Handle the UserAddress "created" event.
     */
    public function created(UserAddress $userAddress): void
    {
        if ($userAddress->is_default) {
            UserAddress::where('user_id', $userAddress->user_id)
                ->whereNot('id', $userAddress->id)
                ->update(['is_default' => false]);
        }
    }

    /**
     * Handle the UserAddress "updated" event.
     */
    public function updated(UserAddress $userAddress): void
    {
        $this->created($userAddress);
    }
}
