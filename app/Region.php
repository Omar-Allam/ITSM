<?php

namespace App;

use App\Behaviors\Listable;

class Region extends Model
{
    use Listable;

    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class, 'region_id', 'id');
    }
}
