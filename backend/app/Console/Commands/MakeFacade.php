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

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => fn (): int|string => search(
                label: 'What is the name of the facade?',
                placeholder: 'E.g. MyLogger',
                options: function (string $value): array {
                    if (strlen($value) === 0) {
                        return [];
                    }

                    // Get all services
                    $services = $this->recursiveScanDir();

                    // Remove file extensions
                    $services = array_map(fn (string $service): string => str_replace('.php', '', $service), $services);

                    return array_filter(
                        $services,
                        fn (string $service): bool => str_contains(strtolower($service), strtolower($value))
                    );
                }
            ),
        ];
    }

    private function recursiveScanDir(string $dir = ''): array
    {
        $path = app_path("Services/{$dir}");
        $allFiles = scandir($path);

        $services = array_filter($allFiles, fn (string $file): bool => ! is_dir("{$path}/{$file}") && str_ends_with($file, '.php'));

        $folders = array_filter($allFiles, fn (string $file): bool => is_dir("{$path}/{$file}") && ! in_array($file, ['.', '..']));
        foreach ($folders as $folder) {
            $services = array_merge($services, $this->recursiveScanDir("{$dir}/{$folder}"));
        }

        return $services;
    }
}
