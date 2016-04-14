<?php

namespace App;

/**
 * @property mixed id
 */
class Location extends Model
{
    protected $fillable = ['name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
