<?php

namespace Titanium\InertiaPreset;

use Illuminate\Support\Arr;
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
        static::updateComposerDependcies();
        static::updateGitIgnore();
        static::updateStyles();
        static::addWebpackAlias();
        static::updateViews();
        static::addScripts();
        static::addControllers();
        static::addRoutes();
        static::addSharedData();
    }

    protected static function updateComposerDependcies()
    {
        static::updateComposer('require', function ($packages) {
            return array_merge(
                $packages,
                [
                    'inertiajs/inertia-laravel' => '^0.2.5',
                    'tightenco/ziggy' => '^0.9.4',
                    'laravel/ui' => '^2.0',
                ]
            );
        });
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
            collect(['/public/*.js', '/public/*.css', '/public/mix-manifest.json', '.DS_Store'])->map(function ($file) {
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

    protected static function updateViews()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->cleanDirectory(resource_path('views'));
            $filesystem->put(
                resource_path('views/app.blade.php'),
                $filesystem->get(static::getStubPath('views/app.blade.php.stub'))
            );
        });
    }

    protected static function addScripts()
    {
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/js', resource_path('js'));
    }

    protected static function addControllers()
    {
        (new Filesystem)->copyDirectory(__DIR__ . '/stubs/Controllers', app_path('Http/Controllers'));
    }

    protected static function addRoutes()
    {
        (new Filesystem)->copy(__DIR__ . '/stubs/routes.stub', base_path('routes/web.php'));
    }

    protected static function addSharedData()
    {
        (new Filesystem)->copy(__DIR__ . '/stubs/AppServiceProvider.stub', app_path('Providers/AppServiceProvider.php'));
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

    protected static function updateComposer($key, $callback)
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $config = json_decode(file_get_contents(base_path('composer.json')), true);
        $config[$key] = $callback(
            Arr::exists($config, $key) ? $config[$key] : []
        );

        ksort($config[$key]);

        (new Filesystem)->put(
            base_path('composer.json'),
            json_encode($config, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    protected static function getStubPath($path)
    {
        return __DIR__ . '/stubs/' . $path;
    }

}
