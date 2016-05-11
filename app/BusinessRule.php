<?php

namespace App;

use App\Behaviors\HasCriteria;

class BusinessRule extends Model
{
    use HasCriteria;
    
    protected $fillable = ['name', 'description', 'is_last'];

    protected $dates = ['created_at', 'updated_at'];

    protected $criteriaType = 'rule';
}
