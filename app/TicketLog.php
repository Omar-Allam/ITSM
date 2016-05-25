<?php

namespace App;

use Carbon\Carbon;

/**
 * App\TicketLog
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ticket_id
 * @property string $old_data
 * @property string $new_data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereOldData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereNewData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketLog extends KModel
{
    protected $fillable = ['user_id', 'type', 'old_data', 'new_data', 'status_id'];

    const UPDATED_TYPE = 1;
    const REPLY_TYPE = 2;
    const APPROVAL_TYPE = 3;
    const APPROVED = 4;
    const DENIED = 5;
    const RESOLVED_TYPE = 6;
    const CLOSED_TYPE = 7;
    const REOPENED_TYPE = 8;

    protected $casts = ['old_data' => 'array', 'new_data' => 'array'];

    public static function addReply(TicketReply $reply)
    {
        return $reply->ticket->logs()->create([
            'user_id' => \Auth::user()->id,
            'type' => static::REPLY_TYPE,
            'old_data' => $reply->ticket->getDirtyOriginals(),
            'new_data' => $reply->ticket->getDirty(),
            'status_id' => $reply->status_id
        ]);
    }

    public static function addApproval(TicketApproval $approval)
    {
        return $approval->ticket->logs()->create([
            'user_id' => \Auth::user()->id,
            'type' => static::APPROVAL_TYPE,
            'old_data' => $approval->ticket->getDirtyOriginals(),
            'new_data' => $approval->ticket->getDirty(),
            'status_id' => $approval->ticket->status_id
        ]);
    }

    public static function addApprovalUpdate($approval, $approved = true)
    {
        return $approval->ticket->logs()->create([
            'user_id' => \Auth::user()->id,
            'type' => $approved? static::APPROVED : static::DENIED,
            'old_data' => $approval->ticket->getDirtyOriginals(),
            'new_data' => $approval->ticket->getDirty(),
            'status_id' => $approval->ticket->status_id
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
