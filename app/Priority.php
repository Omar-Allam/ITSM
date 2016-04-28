<?php

namespace App;

class Priority extends Model
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];
}