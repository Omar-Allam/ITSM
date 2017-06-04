<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalationLevel extends Model
{
    protected $table = 'escalations';
    protected $fillable = ['name','email','sla_id','level','days','hours','minutes'];
}
