<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = ['name', 'type', 'level', 'level_id', 'options', 'required', 'active'];
}
