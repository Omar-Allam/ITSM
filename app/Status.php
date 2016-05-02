<?php

namespace App;

class Status extends Model
{
    const OPEN = 1;
    const PENDING = 2;
    const COMPLETE = 3;

    public static $types = [
        self::OPEN => 'Open',
        self::PENDING => 'Pending',
        self::COMPLETE => 'Completed'
    ];

    protected $fillable = ['name', 'description', 'type'];

    protected $dates = ['created_at', 'updated_at'];
}