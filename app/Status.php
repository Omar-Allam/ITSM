<?php

namespace App;

class Status extends Model
{
    public static $types = [
        1 => 'No Type',
        2 => 'Pending',
        3 => 'Completed'
    ];

    protected $fillable = ['name', 'description', 'type'];

    protected $dates = ['created_at', 'updated_at'];
}