<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 4/28/16
 * Time: 11:50 AM
 */

namespace Make\Makers;


use Carbon\Carbon;
use Illuminate\Support\Str;

class Migration extends Maker
{

    public function make()
    {
        $table = $this->table();
        $class = Str::studly($this->baseName);

        $file = Carbon::now()->format('Y_m_d_His');
        $file .= '_create_' . $table  . '_table.php';
        $filename = database_path('migrations') . static::DS . $file; 

        $content = view()->file($this->stubPath() . static::DS . 'Migration.blade.php', compact('table', 'class'))->render();

        file_put_contents($filename, $content);
    }

}