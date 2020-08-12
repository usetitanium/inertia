<?php

namespace Titanium\InertiaPreset;

use Laravel\Ui\UiCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Titanium\InertiaPreset\InertiaPreset;

class InertiaPresetServiceProvider extends ServiceProvider
{
    protected $adapters = ['vue', 'react'];

    public function boot()
    {
        $this->registerMacros();

        UiCommand::macro('inertia', function ($command) {
            $command->info('Scaffolding...');

            if (
                ! $adapter = collect($command->option('option'))->intersect($this->adapters)->first()
            ) {
                return $command->error('Please provide a valid Inertia adapter (vue, react)');
            }

            (new InertiaPreset)->install(
                $command->option('auth'),
                $adapter,
            );

            $command->info('Inertia scaffolding installed successfully.');
            $command->comment('Run "npm install && npm run dev" to compile your assets.');
        });
    }

    private function registerMacros()
    {
        Stringable::macro('get', function () {
            return $this->value;
        });

        Stringable::macro('indent', function ($spaces = 4) {
            $this->value = collect(Str::of($this->value)->explode(PHP_EOL))
                ->map(function ($string) use ($spaces) {
                    return collect(array_fill(0, $spaces, ' '))->join('') . $string;
                })
                ->join(PHP_EOL);

            return $this;
        });

        Filesystem::macro('insertAfter', function ($file, $place, $insertion) {
            tap(new Filesystem, function ($filesystem) use ($file, $place, $insertion) {
                $contents = $filesystem->get($file);

                if (Str::contains($contents, $insertion)) {
                    return;
                }

                $filesystem->put(
                    $file,
                    Str::beforeLast($contents, $place) . $place . $insertion . Str::afterLast($contents, $place)
                );
            });
        });

        Filesystem::macro('replaceSnippet', function ($file, $existing, $new) {
            tap(new Filesystem, function ($filesystem) use ($file, $existing, $new) {
                $contents = $filesystem->get($file);

                $filesystem->put(
                    $file, 
                    Str::replaceFirst($existing, $new, $contents)
                );
            });
        });

        Filesystem::macro('removeNodeModules', function () {
            tap(new Filesystem, function ($files) {
                $files->deleteDirectory(base_path('node_modules'));

                $files->delete(base_path('yarn.lock'));
                $files->delete(base_path('package-lock.json'));
            });
        });

        Filesystem::macro('updateJsonConfig', function ($file, $key, $callback) {
            tap(new Filesystem, function ($filesystem) use ($file, $key, $callback) {
                if (!$filesystem->exists($file)) {
                    return;
                }

                $config = json_decode($filesystem->get($file), true);

                $config[$key] = $callback(
                    array_key_exists($key, $config) ? $config[$key] : null,
                );

                if (is_array($config[$key])) {
                    ksort($config[$key]);
                }
                
                $filesystem->put($file, json_encode($config, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL);
            });
        });
    }
}
