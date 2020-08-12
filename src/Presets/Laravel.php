<?php

namespace Titanium\InertiaPreset\Presets;

use Titanium\InertiaPreset\Presets\Preset;

class Laravel extends Preset {

    public function install($authentication) {
        $this->updateViews();
        $this->addControllers($authentication);
        $this->addRoutes($authentication);
        $this->addSharedData($authentication);
    }

    protected function updateViews()
    {
        $this->filesystem->cleanDirectory(resource_path('views'));
        $this->filesystem->put(
            resource_path('views/app.blade.php'),
            $this->filesystem->get($this->getStubPath('shared/app.blade.stub'))
        );
    }

    protected function addControllers($authentication)
    {
        if (!$authentication) {
            return;
        }

        $this->filesystem->copyDirectory($this->getStubPath('auth/Controllers'), app_path('Http/Controllers'));
    }

    protected function addRoutes($authentication)
    {
        $path = $authentication ? 'auth/routes.stub': 'non-auth/routes.stub';

        $this->filesystem->copy($this->getStubPath($path), base_path('routes/web.php'));
    }

    protected function addSharedData($authentication)
    {
        $path = $authentication ? 'auth/AppServiceProvider.stub': 'non-auth/AppServiceProvider.stub';

        $this->filesystem->copy($this->getStubPath($path), app_path('Providers/AppServiceProvider.php'));
    }

}
