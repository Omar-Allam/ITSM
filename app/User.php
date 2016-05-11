<?php

namespace App;

use App\Behaviors\Listable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $login
 * @property string $password
 * @property integer $location_id
 * @property integer $business_unit_id
 * @property integer $branch_id
 * @property integer $department_id
 * @property integer $manager_id
 * @property boolean $vip
 * @property boolean $is_ad
 * @property string $remember_token
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[] $groups
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBusinessUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBranchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDepartmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereManagerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereVip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsAd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User technicians()
 * @method static \Illuminate\Database\Query\Builder|\App\User selection($empty = false)
 * @mixin \Eloquent
 */
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
