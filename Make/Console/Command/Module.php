<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 4/27/16
 * Time: 1:14 PM
 */

namespace Make\Console\Command;

use Illuminate\Console\Command;

class Module extends Command
{

    protected $signature = "make:module {name}";

    protected $description = "Create a CRUD resource controller";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $makers = [
            \Make\Makers\Route::class,
            \Make\Makers\Migration::class,
            \Make\Makers\Model::class,
            \Make\Makers\Resource::class,
            \Make\Makers\View::class,
        ];

        $name = $this->argument('name');

        foreach ($makers as $maker) {
            (new $maker($name))->make();
        }
    }
}