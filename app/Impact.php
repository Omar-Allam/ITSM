<?php

namespace App;

class Impact extends Model
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];
}