<?php

namespace App;

/**
 * App\Department
 *
 * @property integer $id
 * @property string $name
 * @property integer $business_unit_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\BusinessUnit $business_unit
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereBusinessUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Department extends KModel
{
    protected $fillable = ['name', 'business_unit_id'];

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }
}
