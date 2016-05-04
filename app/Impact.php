<?php

namespace App;

use App\Behaviors\Listable;

class Impact extends Model
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];

    use Listable;
}