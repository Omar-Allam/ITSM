<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 4/27/16
 * Time: 3:32 PM
 */

namespace Make\Makers;


use Illuminate\Support\Str;

abstract class Maker
{
    protected $name;

    protected $baseName;

    protected $dirName;

    const DS = DIRECTORY_SEPARATOR;

    public function __construct($name)
    {
        $this->name = $name;
        $this->baseName = basename($this->name);
        $this->dirName = dirname($this->name);
    }

    abstract public function make();

    protected function humanize()
    {
        return Str::ucfirst(str_replace('_', ' ', Str::snake($this->baseName, '_')));
    }

    Protected function viewPrefix()
    {
        $tokens = array_map(function($t) {
            return Str::snake($t, '-');
        }, preg_split('/[\/\\\\]/', $this->name));

        return implode('.', $tokens);
    }

    protected function single()
    {
        return Str::camel(Str::singular($this->baseName));
    }

    protected function plural()
    {
        return Str::camel(Str::plural($this->baseName));
    }
}