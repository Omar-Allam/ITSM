<?php

namespace App;

class Sla extends Model
{
    protected $fillable = ['name', 'description', 'due_days', 'due_hours', 'due_minutes', 'response_days', 'response_hours', 'response_minutes', 'critical'];

    protected $dates = ['created_at', 'updated_at'];
}
