<?php

namespace App;

class Department extends Model
{
    protected $fillable = ['name', 'business_unit_id'];

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }
}
