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
    public function boot()
    {
        $this->registerMacros();

        UiCommand::macro('inertia', function ($command) {
            InertiaPreset::install();

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

        Filesystem::macro('replaceSnippet', function ($file, $existing , $new) {
            tap(new Filesystem, function ($filesystem) use ($file, $existing, $new) {
                $contents = $filesystem->get($file);

                $filesystem->put(
                    $file, 
                    Str::replaceFirst($existing, $new, $contents)
                );
            });
        });
    }
}
