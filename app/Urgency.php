<?php

namespace App;

class Urgency extends Model
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];
}