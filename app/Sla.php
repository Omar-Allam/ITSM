<?php

namespace App;

use App\Behaviors\HasCriteria;

class Sla extends Model
{
    use HasCriteria;

    protected $fillable = ['name', 'description', 'due_days', 'due_hours', 'due_minutes', 'response_days', 'response_hours', 'response_minutes', 'critical'];

    protected $dates = ['created_at', 'updated_at'];

    protected $criteriaType = 'sla';
}
