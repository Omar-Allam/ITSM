<?php

namespace App;

class Group extends Model
{
    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];
}