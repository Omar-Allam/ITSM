<?php

namespace App;

use App\Behaviors\Listable;

/**
 * App\BusinessUnit
 *
 * @property integer $id
 * @property string $name
 * @property integer $location_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Location $location
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessUnit selection($empty = false)
 * @mixin \Eloquent
 */
class BusinessUnit extends KModel
{
    use Listable;

    protected $fillable = ['name', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
