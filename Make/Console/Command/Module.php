<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 4/27/16
 * Time: 1:14 PM
 */

namespace Make\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Module extends Command
{

    protected $signature = "make:resource {name}";

    protected $description = "Create a CRUD resource controller";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $makers = [
            \Make\Makers\View::class,
            \Make\Makers\Resource::class,
        ];

        $name = $this->argument('name');

        foreach ($makers as $maker) {
            (new $maker($name))->make();
        }
    }
}