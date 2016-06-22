<?php

namespace App;

use App\Behaviors\Listable;

/**
 * App\Region
 *
 * @property integer $id
 * @property string $name
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\City[] $cities
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region selection($empty = false)
 * @mixin \Eloquent
 */
class Region extends KModel
{
    use Listable;

    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class, 'region_id', 'id');
    }
}
