<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreated;
use Illuminate\Database\Eloquent\Builder;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        User::whereHas('role', fn (Builder $query): Builder => $query->where('name', UserRole::ADMIN))
            ->first()
            ->notify(new OrderCreated($order));
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // $order->user->notify(new OrderStatusUpdated($order));
    }
}
