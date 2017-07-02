<?php

namespace App;

use App\Helpers\HistoryEntry;

/**
 * App\TicketLog
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ticket_id
 * @property integer $status_id
 * @property string $type
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
    const CLOSED_TYPE = 7;
    const AUTO_CLOSE = 10;
//    const REOPENED_TYPE = 8;

    protected $casts = ['old_data' => 'array', 'new_data' => 'array'];

    public static function addReply(TicketReply $reply)
    {
        self::makeLog($reply->ticket, static::REPLY_TYPE, $reply->user_id);
    }

    public static function addApproval(TicketApproval $approval)
    {
        return self::makeLog($approval->ticket, static::APPROVAL_TYPE, $approval->creator_id);
    }

    public static function addApprovalUpdate(TicketApproval $approval, $approved = true)
    {
        return self::makeLog($approval->ticket, $approved ? static::APPROVED : static::DENIED, $approval->approver_id);
    }

    public static function addUpdating(Ticket $ticket)
    {
        return self::makeLog($ticket, static::UPDATED_TYPE);
    }

    public static function addClose(Ticket $ticket)
    {
        return self::makeLog($ticket, static::CLOSED_TYPE);
    }

    public static function addAutoClose(Ticket $ticket)
    {
        return self::makeLog($ticket, static::AUTO_CLOSE, $ticket->requester_id);
    }

    public static function makeLog(Ticket $ticket, $type, $user_id = null)
    {
        $user_id = $user_id ?: \Auth::user()->id ?? 0;
        return $ticket->logs()->create([
            'user_id' => $user_id,
            'type' => $type,
            'old_data' => $ticket->getDirtyOriginals(),
            'new_data' => $ticket->getDirty(),
            'status_id' => $ticket->status_id
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getTypeActionAttribute()
    {
        $actions = [
            self::REPLY_TYPE => 'replied',
            self::APPROVAL_TYPE => 'submitted for approval',
            self::APPROVED => 'approved',
            self::DENIED => 'denied',
        ];

        if (isset($actions[$this->type])) {
            if ($this->type == self::REPLY_TYPE && $this->status_id == 7) {
                return 'resolved';
            }
            return $actions[$this->type];
        }

        return 'updated';
    }

    public function getEntriesAttribute()
    {
        $entries = [];

        foreach ($this->old_data as $key => $value) {
            $entries[] = new HistoryEntry($key, $value, $this->new_data[$key]);
        }

        return $entries;
    }

    function getStartTimeAttribute()
    {
        $critical = $this->ticket->sla->critical ?? false;
        $date = clone $this->created_at;

        if (!$critical) {
           // If it is not critical and time is outside working hours
            // move the time to nearest working hour possible.
            $dayStart = (clone $this->created_at)->setTimeFromTimeString(config('worktime.start'));
            $dayEnd = (clone $this->created_at)->setTimeFromTimeString(config('worktime.end'));

            if ($date->lt($dayStart)) {
                // If it is before work start move to work start
                $date = $dayStart;
            } elseif ($date->gt($dayEnd)) {
                // If it is after working hours move to next day's start
                do {
                    $date = $dayStart->addDay();
                } while ($date->isWeekend());
            }
        }

        return $date;
    }
}
