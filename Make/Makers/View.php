<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 4/27/16
 * Time: 3:30 PM
 */

namespace Make\Makers;


use Illuminate\Support\Str;

class View extends Maker
{
    public function make()
    {
        $viewsPath = resource_path('views');
        $path = $viewsPath . static::DS . $this->getViewPath();

        is_dir($path) ||  mkdir($path, 0755, true);

        $stubs = $this->stubPath() . static::DS . 'views';

        $single = $this->single();
        $plural = $this->plural();
        $humanUp = $this->humanize();
        $humanLow = strtolower($humanUp);
        $viewPrefix = $this->viewPrefix();
        $data = compact('single', 'plural', 'humanUp', 'humanLow', 'viewPrefix');

        foreach (['index', '_form', 'create', 'edit'] as $file) {
            $filename = $path . static::DS . $file . '.blade.php';
            $content = view()->file($stubs . static::DS . $file . '.blade.php', $data)->render();

            file_put_contents($filename, $content);
        }
    }

    protected function getViewPath()
    {
        $tokens = array_map(function($t) {
            return Str::snake($t, '-');
        }, preg_split('/[\/\\\\]/', $this->name));

        return implode(static::DS, $tokens);
    }
}