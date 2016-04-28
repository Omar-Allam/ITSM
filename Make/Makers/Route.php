<?php

namespace Make\Makers;

class Route extends Maker
{

    public function make()
    {
        $name = str_replace('.', '/', $this->viewPrefix());

        $namespace = '';
        if ($this->dirName != '.' && $this->baseName != $this->dirName) {
            $namespace = str_replace('/', '\\', $this->dirName);
        }
        
        $controller = $namespace . '\\' . $this->baseName;

        $route = PHP_EOL . "Route::resource('$name', '$controller');" . PHP_EOL;

        $routers = app_path('Http' . static::DS . 'routes.php');
        $content = file_get_contents($routers);

        $content .= $route;
        file_put_contents($routers, $content);
    }
}