<?php

namespace Titanium\InertiaPreset;

use Illuminate\Support\Arr;
use Laravel\Ui\Presets\Preset;

class InertiaPreset extends Preset
{

    public static function install()
    {
        static::updatePackages();
        static::updatePackages(false);
    }

    protected static function updatePackageArray(array $packages, $key)
    {
        if ($key === 'devDependencies') {
            return static::updateDevDependenciesArray($packages);
        }

        return static::updateDependenciesArray($packages);
    }

    protected static function updateDevDependenciesArray($packages)
    {
        return [
            'cross-env' => '^7.0',
            'laravel-mix' => '^5.0.1',
            'resolve-url-loader' => '^2.3.1',
            'vue' => '^2.5.17',
            'vue-template-compiler' => '^2.6.10',
        ];
    }

    protected static function updateDependenciesArray($packages)
    {
        return [
            '@inertiajs/inertia' => '^0.1.9',
            '@inertiajs/inertia-vue' => '^0.1.4',
        ];
    }

}
