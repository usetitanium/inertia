<?php

namespace Titanium\InertiaPreset\Presets;

use Illuminate\Support\Str;
use Titanium\InertiaPreset\Presets\Preset;

class Vue extends Preset {

    public function install($authentication) {
        $this->updateDependencies();
        $this->removeNodeModules();
        $this->updateGitIgnore();
        $this->updateStyles();
        $this->addScripts($authentication);
        $this->addWebpackAlias();
    }

    protected function updateDependencies()
    {
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

    protected function updateGitIgnore()
    {
        $contents = $this->filesystem->get(base_path('.gitignore'));

        $inserts = collect(['/public/*.js', '/public/*.css', '/public/mix-manifest.json', '.DS_Store'])->map(function ($file) {
            return Str::of($file)->finish(PHP_EOL)->get();
        })->join('');
        
        $result = Str::of($contents)->finish($inserts)->get();
        
        $this->filesystem->put(base_path('.gitignore'), $result);
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

    protected function addScripts($authentication)
    {
        $path = $authentication ? 'auth/vue' : 'non-auth/vue';

        $this->filesystem->copyDirectory($this->getStubPath($path), resource_path('js'));
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

}
