<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Laravel\Scout\Console\ImportCommand;

class UpdateScoutIndexes extends ImportCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:update-indexes
            {model : Class name of model to bulk import}
            {--c|chunk= : The number of records to import at a time (Defaults to configuration value: `scout.chunk.searchable`)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Scout indexes';
}
