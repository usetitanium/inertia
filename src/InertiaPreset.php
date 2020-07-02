<?php

namespace Titanium\InertiaPreset;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Ui\Presets\Preset;
use Illuminate\Filesystem\Filesystem;

class InertiaPreset
{
    protected $authentication;
    protected $filesystem;

    public function __construct($authentication)
    {
        $this->authentication = $authentication;
        $this->filesystem = new Filesystem;
    }

    public function install()
    {
        $this->updateFrontendDependencies();
        $this->removeNodeModules();
        $this->updateComposerDependcies();
        $this->updateGitIgnore();
        $this->updateStyles();
        $this->addWebpackAlias();
        $this->updateViews();
        $this->addScripts();
        $this->addControllers();
        $this->addRoutes();
        $this->addSharedData();
    }

    protected function updateFrontendDependencies() {
        // Update Dependencies
        $this->filesystem->updateJsonConfig(
            base_path('package.json'),
            'dependencies', 
            function () {
                return [
                    '@inertiajs/inertia' => '^0.1.9',
                    '@inertiajs/inertia-vue' => '^0.1.4',
                ];
            }
        );

        // Update dev dependencies
        $this->filesystem->updateJsonConfig(
            base_path('package.json'),
            'devDependencies', 
            function () {
                return [
                    'cross-env' => '^7.0',
                    'laravel-mix' => '^5.0.1',
                    'resolve-url-loader' => '^2.3.1',
                    'vue' => '^2.5.17',
                    'vue-template-compiler' => '^2.6.10',
                ];
            }
        );
    }

    protected function removeNodeModules()
    {
        $this->filesystem->removeNodeModules();
    }

    protected function updateComposerDependcies()
    {
        $this->filesystem->updateJsonConfig(
            base_path('composer.json'),
            'require',
            function ($packages = []) {
                return array_merge(
                    $packages,
                    [
                        'inertiajs/inertia-laravel' => '^0.2.5',
                        'tightenco/ziggy' => '^0.9.4',
                        'laravel/ui' => '^2.0',
                    ]
                );
            }
        );
    }

    protected function updateGitIgnore()
    {
        $this->filesystem->insertAfter(
            base_path('.gitignore'),
            Str::of('/public/storage')->finish(PHP_EOL),
            collect(['/public/*.js', '/public/*.css', '/public/mix-manifest.json', '.DS_Store'])->map(function ($file) {
                return Str::of($file)->finish(PHP_EOL)->get();
            })->join(''),
        );
    }

    protected function updateStyles()
    {
        $this->filesystem->replaceSnippet(
            base_path('webpack.mix.js'),
            $this->filesystem->get($this->getStubPath('shared/webpack/sass.stub')),
            $this->filesystem->get($this->getStubPath('shared/webpack/css.stub'))
        );

        $this->filesystem->deleteDirectory(resource_path('sass'));

        if (!$this->filesystem->exists(resource_path('css'))) {
            $this->filesystem->makeDirectory(resource_path('css'));
        }

        $this->filesystem->put(resource_path('css/app.css'), '');
    }

    protected function addWebpackAlias()
    {
        $this->filesystem->insertAfter(
           base_path('webpack.mix.js'),
            ".copy('resources/css/app.css', 'public/css')",
            Str::of($this->filesystem->get($this->getStubPath('shared/webpack/alias.stub')))
                ->start(PHP_EOL)
                ->indent()
        );
    }

    protected function updateViews()
    {
        $this->filesystem->cleanDirectory(resource_path('views'));
        $this->filesystem->put(
            resource_path('views/app.blade.php'),
            $this->filesystem->get($this->getStubPath('shared/app.blade.stub'))
        );
    }

    protected function addScripts()
    {
        $path = $this->authentication ? 'auth/js' : 'non-auth/js';

        $this->filesystem->copyDirectory($this->getStubPath($path), resource_path('js'));
    }

    protected function addControllers()
    {
        if (!$this->authentication) {
            return;
        }

        $this->filesystem->copyDirectory($this->getStubPath('auth/Controllers'), app_path('Http/Controllers'));
    }

    protected function addRoutes()
    {
        $path = $this->authentication ? 'auth/routes.stub': 'non-auth/routes.stub';

        $this->filesystem->copy($this->getStubPath($path), base_path('routes/web.php'));
    }

    protected function addSharedData()
    {
        $path = $this->authentication ? 'auth/AppServiceProvider.stub': 'non-auth/AppServiceProvider.stub';

        $this->filesystem->copy($this->getStubPath($path), app_path('Providers/AppServiceProvider.php'));
    }

    protected function getStubPath($path)
    {
        return __DIR__ . '/stubs/' . $path;
    }

}
