<?php

namespace App;

use App\Behaviors\Listable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Group
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $type
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group support()
 * @method static \Illuminate\Database\Query\Builder|\App\Group types()
 * @method static \Illuminate\Database\Query\Builder|\App\Group selection($empty = false)
 * @mixin \Eloquent
 */
class Group extends KModel
{
    protected $fillable = ['name', 'description', 'type'];

    protected $dates = ['created_at', 'updated_at'];

    const REQUESTER = 1;
    const COORDINATOR = 2;
    const TECHNICIAN = 3;
    const ADMIN = 4;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany('App\User','group_supervisor','group_id','user_id');
    }

    public function scopeSupport(Builder $query)
    {
        return $query->where('type', '!=', self::REQUESTER);
    }

    public function scopeTechnician(Builder $query)
    {
        return $query->where('type', self::TECHNICIAN);
    }

    public function scopeAdmin(Builder $query)
    {
        return $query->where('type', self::ADMIN);
    }

    public function scopeTypes()
    {
        $types = collect([
            self::REQUESTER => 'Requesters',
            self::COORDINATOR => 'Coordinators',
            self::TECHNICIAN => 'Technicians',
            self::ADMIN => 'Administrators'
        ]);

        $types->sort();
        $types->prepend('Select Type', '');

        return $types;
    }

    function isSupervisor()
    {
        $groups = $this->technician->groups;
        if ($groups->count()) {
            $group_ids = $groups->map(function ($group) {
                return $group->supervisors->pluck('id');
            });
        }
        dd($group_ids);
    }
    use Listable;
}