<?php

namespace App;

use App\Behaviors\Listable;

/**
 * App\Location
 *
 * @property mixed id
 * @property integer $id
 * @property string $name
 * @property integer $city_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\City $city
 * @method static \Illuminate\Database\Query\Builder|\App\Location whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Location whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Location whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Location selection($empty = false)
 * @mixin \Eloquent
 */
class Location extends KModel
{
    use Listable;

    protected $fillable = ['name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
