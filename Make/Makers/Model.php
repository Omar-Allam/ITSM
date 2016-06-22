<?php

namespace Make\Makers;


class Model extends Maker
{

    public function make()
    {
        $className = $this->baseName;
        $filename = app_path($className . '.php');

        $content = \View::file($this->stubPath() . static::DS . 'Model.blade.php', compact('className'))->render();

        file_put_contents($filename, $content);
    }

}