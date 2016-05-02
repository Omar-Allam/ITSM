<?php

namespace App;

class Group extends Model
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

    public function scopeTypes ()
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
}