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


    function shouldEscalate($ticket){
        $previous_escalations = TicketLog::where('type',13)
            ->where('ticket_id',$ticket->id)->count();

        if($this->level > $previous_escalations){

            $startTime = Carbon::parse(config('worktime.start'));
            $endTime = Carbon::parse(config('worktime.end'));
            $minutesPerDay = $endTime->diffInMinutes($startTime);

            $escalate_time = ($this->days * $minutesPerDay) + ($this->hours * 60) + $this->minutes;
            $escalation_time = $ticket->due_date->addMinutes($escalate_time) ;

            /** @var Carbon $escalation_time */
            if(Carbon::now()->gt($escalation_time)){
                return true;
            }
            return false;
        }

    }

}

