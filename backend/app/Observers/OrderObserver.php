<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderConfirmation;
use App\Notifications\OrderCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

final class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $admin = User::whereHas('role', fn (Builder $query): Builder => $query->where('name', UserRole::ADMIN))->first();
        Notification::send($admin, new OrderCreated($order));

        $order->user->notify(new OrderConfirmation($order));
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // $order->user->notify(new OrderStatusUpdated($order));
    }
}
