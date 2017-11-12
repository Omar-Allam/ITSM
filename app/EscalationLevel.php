<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EscalationLevel extends Model
{
    protected $table = 'escalations';
    protected $fillable = ['name','user_id','sla_id','level','assign','when_escalate','days','hours','minutes'];

    function user(){
        return $this->belongsTo(User::class,'user_id');
    }



}

