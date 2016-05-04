<?php

namespace App;

use App\Behaviors\Listable;

class Priority extends Model
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];

    use Listable;
}