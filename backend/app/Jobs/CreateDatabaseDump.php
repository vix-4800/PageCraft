<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\DatabaseDumpCreated;
use App\Services\DatabaseDumpers\DatabaseDumper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateDatabaseDump implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $filename
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        resolve(DatabaseDumper::class)->create($this->filename);

        DatabaseDumpCreated::dispatch();
    }
}
