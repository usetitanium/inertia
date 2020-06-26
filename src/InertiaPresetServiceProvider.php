<?php

namespace Titanium\InertiaPreset;

use Laravel\Ui\UiCommand;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Titanium\InertiaPreset\InertiaPreset;

class InertiaPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
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

        UiCommand::macro('inertia', function ($command) {
            InertiaPreset::install();

            $command->info('Inertia scaffolding installed successfully.');
            $command->comment('Run "npm install && npm run dev" to compile your assets.');
        });
    }
}
