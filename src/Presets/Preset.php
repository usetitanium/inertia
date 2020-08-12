<?php

namespace Titanium\InertiaPreset\Presets;

use Illuminate\Filesystem\Filesystem;

abstract class Preset {
    
    protected $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem;
    }

    protected function getStubPath($path)
    {
        return __DIR__ . '/../stubs/' . $path;
    }

    abstract public function install($authentication);

}
