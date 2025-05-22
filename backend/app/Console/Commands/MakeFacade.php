<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

use function Laravel\Prompts\search;

final class MakeFacade extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:facade {name : The name of the facade} { service : The name of the service}';

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

        $service = $this->argument('service');
        if (is_int($service)) {
            $service = $this->recursiveScanDir()[$service];
        }

        $stubFile = resource_path('stubs/facade.stub');
        $targetFile = app_path(sprintf('Facades/%s.php', $name));

        if (! file_exists(app_path('Facades'))) {
            mkdir(app_path('Facades'), 0755);
        }

        copy($stubFile, $targetFile);

        $createdFacadeContent = file_get_contents($targetFile);
        $createdFacadeContent = str_replace('{{name}}', $name, $createdFacadeContent);
        $createdFacadeContent = str_replace('MyService', $service, $createdFacadeContent);
        file_put_contents($targetFile, $createdFacadeContent);

        $this->info(sprintf('Facade %s created!', $name));
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'What is the name of the facade?',
            'service' => fn (): int|string => search(
                label: 'What is the name of the service?',
                placeholder: 'E.g. MyLogger',
                options: function (string $value): array {
                    if (mb_strlen($value) === 0) {
                        return [];
                    }

                    return array_filter(
                        $this->recursiveScanDir(),
                        fn (string $service): bool => str_contains(mb_strtolower($service), mb_strtolower($value))
                    );
                },
                hint: 'Enter the name of the facade',
            ),
        ];
    }

    /**
     * Recursively scan the "app/Services" directory and return an array of all PHP files (without extension)
     * found.
     *
     * @param  string  $dir  The subdirectory to start scanning from, defaults to empty string.
     * @return array<string> An array of all services, without the ".php" extension.
     */
    private function recursiveScanDir(string $dir = ''): array
    {
        $path = app_path('Services/'.$dir);
        $allFiles = scandir($path);

        $services = array_filter($allFiles, fn (string $file): bool => ! is_dir(sprintf('%s/%s', $path, $file)) && str_ends_with($file, '.php'));

        $folders = array_filter($allFiles, fn (string $file): bool => is_dir(sprintf('%s/%s', $path, $file)) && ! in_array($file, ['.', '..']));
        foreach ($folders as $folder) {
            $services = array_merge($services, $this->recursiveScanDir(sprintf('%s/%s', $dir, $folder)));
        }

        $services = array_map(fn (string $service): string => str_replace('.php', '', $service), $services);

        return $services;
    }
}
