<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

use function Laravel\Prompts\search;

class MakeFacade extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:facade {name : The name of the facade}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new facade';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');

        $stubFile = resource_path('stubs/facade.stub');
        $targetFile = app_path("Facades/{$name}.php");

        if (! file_exists(app_path('Facades'))) {
            mkdir(app_path('Facades'), 0755);
        }

        copy($stubFile, $targetFile);

        $createdFacadeContent = file_get_contents($targetFile);
        $createdFacadeContent = str_replace('{{name}}', $name, $createdFacadeContent);
        file_put_contents($targetFile, $createdFacadeContent);

        $this->info("Facade {$name} created!");
    }
}
