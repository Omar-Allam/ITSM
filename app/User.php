<?php

namespace App;

use App\Behaviors\Listable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'login', 'password', 'location_id', 'location_id', 'business_unit_id',
        'branch_id', 'department_id', 'manager_id', 'vip', 'is_ad'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    use Listable;

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function scopeTechnicians(Builder $query)
    {
        return $query->whereHas('groups', function (Builder $q) {
            $q->support();
        });
    }
}
