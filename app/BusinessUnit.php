<?php

namespace App;

use App\Behaviors\Listable;

class BusinessUnit extends Model
{
    use Listable;

    protected $fillable = ['name', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
