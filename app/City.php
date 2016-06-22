<?php

namespace App;

use App\Behaviors\Listable;

/**
 * App\City
 *
 * @property mixed id
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Region $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Location[] $locations
 * @method static \Illuminate\Database\Query\Builder|\App\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereRegionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\City selection($empty = false)
 * @mixin \Eloquent
 */
class City extends KModel
{
    use Listable;

    protected $fillable = ['name', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'city_id', 'id');
    }
}
