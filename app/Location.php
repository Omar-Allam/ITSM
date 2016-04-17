<?php

namespace App;

use App\Behaviors\Listable;

/**
 * @property mixed id
 */
class Location extends Model
{
    use Listable;

    protected $fillable = ['name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
