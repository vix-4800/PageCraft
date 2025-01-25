<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\DatabaseNotificationType;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;

class OrderCreated extends BaseDatabaseNotification
{
    protected Order $model;

    protected function getType(): DatabaseNotificationType
    {
        return DatabaseNotificationType::ORDER;
    }

    protected function getMessage(): string
    {
        return 'Order created';
    }

    protected function getDetails(): OrderResource
    {
        return new OrderResource($this->model);
    }
}
