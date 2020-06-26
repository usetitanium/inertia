<?php

namespace Titanium\InertiaPreset;

use Illuminate\Support\Str;
use Laravel\Ui\Presets\Preset;
use Illuminate\Filesystem\Filesystem;

class InertiaPreset extends Preset
{

    public static function install()
    {
        static::removeNodeModules();
        static::updatePackages();
        static::updatePackages(false);
        static::updateGitIgnore();
        static::updateStyles();
        static::addWebpackAlias();
    }

    protected static function updatePackageArray(array $packages, $key)
    {
        if ($key === 'devDependencies') {
            return static::updateDevDependenciesArray($packages);
        }

        return static::updateDependenciesArray($packages);
    }

    protected static function updateGitIgnore()
    {
        (new Filesystem)->insertAfter(
            base_path('.gitignore'),
            Str::of('/public/storage')->finish(PHP_EOL),
            collect(['/public/*.js', '/public/*.css', '/public/mix-manifest.json'])->map(function ($file) {
                return Str::of($file)->finish(PHP_EOL)->get();
            })->join(''),
        );
    }

    protected static function updateStyles()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->replaceSnippet(
                base_path('webpack.mix.js'),
                $filesystem->get(static::getStubPath('webpack/sass.stub')),
                $filesystem->get(static::getStubPath('webpack/css.stub'))
            );

            $filesystem->deleteDirectory(resource_path('sass'));

            if (!$filesystem->exists(resource_path('css'))) {
                $filesystem->makeDirectory(resource_path('css'));
            }

            $filesystem->put(resource_path('css/app.css'), '');
        });
    }

    protected static function addWebpackAlias()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->insertAfter(
               base_path('webpack.mix.js'),
                ".copy('resources/css/app.css', 'public/css')",
                Str::of($filesystem->get(static::getStubPath('webpack/alias.stub')))
                    ->start(PHP_EOL)
                    ->indent()
            );
        });
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

    protected static function getStubPath($path)
    {
        return __DIR__ . '/stubs/' . $path;
    }

}
