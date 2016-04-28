<?php

namespace Make\Makers;

use Illuminate\Support\Str;

class Resource extends Maker
{
    public function make()
    {
        $stubPath = $this->stubPath();

        $model = Str::studly($this->baseName);

        $filename = app_path('Http/Controller') . static::DS . $this->dirName . static::DS . $model . 'Controller.php';

        $namespace = '';
        if ($this->dirName != '.' && $this->baseName != $this->dirName) {
            $namespace = '\\' . str_replace(['/', '\\'], '\\', $this->dirName);
            $importController = true;
        }

        $single = $this->single();
        $plural = $this->plural();
        $humanUp = $this->humanize();
        $humanDown = Str::lower($humanUp);
        $viewPrefix = $this->viewPrefix();

        $content = \View::file($stubPath . static::DS . 'resource.blade.php', compact('model', 'single', 'plural', 'humanUp', 'humanDown', 'importController', 'namespace', 'viewPrefix'))->render();

        file_put_contents($filename, $content);
    }

}