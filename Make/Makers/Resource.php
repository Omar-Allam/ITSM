<?php

namespace Make\Makers;

use Illuminate\Support\Str;

class Resource extends Maker
{
    public function make()
    {
        $ds = DIRECTORY_SEPARATOR;
        $stubPath = dirname(__DIR__) . $ds . 'stubs';

        $model = Str::studly($this->baseName);

        $filename = app_path('Http/Controller') . $ds . $this->dirName . $ds . $model . 'Controller.php';

        $namespace = '';
        if ($this->dirName != '.' && $this->baseName != $this->dirName) {
            $namespace = '\\' . str_replace($ds, '\\', $this->dirName);
            $importController = true;
        }

        $single = $this->single();
        $plural = $this->plural();
        $humanUp = $this->humanize();
        $humanDown = Str::lower($humanUp);
        $viewPrefix = $this->viewPrefix();

        $content = \View::file($stubPath . $ds . 'resource.blade.php', compact('model', 'single', 'plural', 'humanUp', 'humanDown', 'importController', 'namespace', 'viewPrefix'))->render();

        file_put_contents($filename, $content);
    }

}