<?php

namespace Titanium\InertiaPreset;

use Laravel\Ui\UiCommand;
use Illuminate\Support\ServiceProvider;
use Titanium\InertiaPreset\InertiaPreset;

class InertiaPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('inertia', function ($command) {
            InertiaPreset::install();
        });
    }
}
