<?php

namespace App;

use App\Behaviors\Listable;

/**
 * @property mixed id
 */
class City extends Model
{
    use Listable;

    protected $fillable = ['name', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
