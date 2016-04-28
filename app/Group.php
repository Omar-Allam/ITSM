<?php

namespace App;

class Group extends Model
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];
}