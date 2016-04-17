<?php

namespace App;

use App\Behaviors\Listable;

class Region extends Model
{
    use Listable;

    protected $fillable = ['name'];
}
