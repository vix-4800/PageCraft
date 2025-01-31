<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\OneTimePassword;
use App\Notifications\OtpCode;

class OneTimePasswordObserver
{
    /**
     * Handle the OneTimePassword "created" event.
     */
    public function created(OneTimePassword $oneTimePassword): void
    {
        $oneTimePassword->user->notify(new OtpCode($oneTimePassword->code));
    }
}
