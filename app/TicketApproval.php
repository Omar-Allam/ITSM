<?php

namespace App;


/**
 * App\TicketApproval
 *
 * @property integer $id
 * @property integer $creator_id
 * @property integer $approver_id
 * @property integer $ticket_id
 * @property string $comment
 * @property string $approval_date
 * @property string $status
 * @property Ticket $ticket
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereCreatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereApproverId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereApprovalDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketApproval whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketApproval extends KModel
{
    protected $fillable = ['approver_id', 'content', 'status', 'comment', 'approval_date', 'stage'];

    protected $dates = ['created_at', 'updated_at', 'approval_date'];

    const APPROVED = 1;
    const PENDING_APPROVAL = 0;
    const DENIED = -1;

    public static $statuses = [
        self::APPROVED => 'Approved',
        self::DENIED => 'Denied',
        self::PENDING_APPROVAL => 'Pending Approval'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function shouldSend()
    {
        $pendingCount = $this->ticket->approvals()
            ->where('stage', '<', $this->stage)
            ->where('status', static::PENDING_APPROVAL)
            ->count();

        return $pendingCount == 0;
    }

    public function hasNext()
    {
        return $this->ticket->approvals()->where('stage', '>', $this->stage)->count() > 0;
    }

    public function getNextStage()
    {

    }
}
