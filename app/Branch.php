<?php

namespace App;

/**
 * App\Branch
 *
 * @property integer $id
 * @property string $name
 * @property integer $business_unit_id
 * @property integer $location_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\BusinessUnit $business_unit
 * @property-read \App\Location $location
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereBusinessUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Branch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Branch extends KModel
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
