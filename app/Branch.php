<?php

namespace App;

class Branch extends Model
{
    protected $fillable = ['name', 'business_unit_id', 'location_id'];

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
