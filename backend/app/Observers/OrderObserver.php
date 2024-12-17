<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreated;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $order->status = OrderStatus::CREATED;
        $order->saveQuietly();

        User::first()->notify(new OrderCreated($order));
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
