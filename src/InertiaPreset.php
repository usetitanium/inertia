<?php

namespace Titanium\InertiaPreset;

use Laravel\Ui\Presets\Preset;
use Titanium\InertiaPreset\Presets\Vue;
use Titanium\InertiaPreset\Presets\Laravel;

class InertiaPreset
{

    public function install($authentication = false, $adapter)
    {
        $this->laravel($authentication);
        $this->{$adapter}($authentication);
    }

    protected function laravel($authentication) {
        (new Laravel)->install($authentication);
    }

    protected function vue($authentication) {
        (new Vue)->install($authentication);
    }

}
