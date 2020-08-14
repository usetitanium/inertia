<?php

namespace Titanium\InertiaPreset\Presets;

use Illuminate\Support\Str;
use Titanium\InertiaPreset\Presets\Preset;

class React extends Preset {

    public function install($authentication) {
        $this->updateDependencies();
        $this->removeNodeModules();
        $this->updateWebpackConfig();
        $this->updateGitIgnore();
        $this->updateStyles();
        // $this->addScripts($authentication);
    }

    protected function updateDependencies()
    {
        // Update Dependencies
        $this->filesystem->updateJsonConfig(
            base_path('package.json'),
            'dependencies', 
            function () {
                return [
                    '@inertiajs/inertia' => '^0.1',
                    '@inertiajs/inertia-react' => '^0.1',
                ];
            }
        );

        // Update dev dependencies
        $this->filesystem->updateJsonConfig(
            base_path('package.json'),
            'devDependencies', 
            function () {
                return [
                    '@babel/preset-react': '^7.0.0',
                    'cross-env' => '^7.0',
                    'react': '^16.2.0',
                    'react-dom': '^16.2.0',
                    'laravel-mix' => '^5.0.1',
                    'resolve-url-loader' => '^2.3.1',
                ];
            }
        );
    }

    protected function removeNodeModules()
    {
        $this->filesystem->removeNodeModules();
    }

    protected function updateWebpackConfig()
    {
        $contents = $this->filesystem->get(base_path('webpack.mix.js'));
        $contents = Str::of($contents)
            // Update compilation step
            ->replace('mix.js', 'mix.react')
            // Update css step
            ->replace(
                $this->filesystem->get($this->getStubPath('shared/webpack/sass.stub')),
                $this->filesystem->get($this->getStubPath('shared/webpack/css.stub'))
            )
            // Insert alias
            ->insert(
                $this->filesystem->get($this->getStubPath('shared/webpack/css.stub')),
                Str::of($this->filesystem->get($this->getStubPath('shared/webpack/alias.stub')))
                ->start(PHP_EOL)
                ->indent()
            )
            ->get();  

        // Add alias
        $this->filesystem->put(
           base_path('webpack.mix.js'),
           $contents
        );
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
        $this->filesystem->deleteDirectory(resource_path('sass'));

        if (!$this->filesystem->exists(resource_path('css'))) {
            $this->filesystem->makeDirectory(resource_path('css'));
        }

        $this->filesystem->put(resource_path('css/app.css'), '');
    }

    // protected function addScripts($authentication)
    // {
    //     $path = $authentication ? 'auth/js' : 'non-auth/js';

    //     $this->filesystem->copyDirectory($this->getStubPath($path), resource_path('js'));
    // }

}
