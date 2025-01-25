<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Http\Resources\FeedbackMessageResource;
use App\Models\FeedbackMessage;

class FeedbackMessageCreated extends BaseDatabaseNotification
{
    protected FeedbackMessage $model;

    protected function getType(): string
    {
        return 'feedback_message';
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
