<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Enums\DatabaseNotificationType;
use App\Http\Resources\FeedbackMessageResource;

class FeedbackMessageCreated extends BaseDatabaseNotification
{
    protected function getType(): DatabaseNotificationType
    {
        return DatabaseNotificationType::FEEDBACK_MESSAGE;
    }

    protected function getMessage(): string
    {
        return 'New feedback message received';
    }

    protected function getDetails(): FeedbackMessageResource
    {
        return new FeedbackMessageResource($this->model);
    }
}
