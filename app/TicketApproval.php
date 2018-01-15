<?php

namespace App;

use App\Jobs\SendApproval;


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
 * @property integer stage
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
    protected $fillable = ['approver_id', 'content', 'status', 'comment', 'approval_date', 'stage', 'creator_id','ticket_id','created_at', 'updated_at'];

    protected $dates = ['created_at', 'updated_at', 'approval_date'];

    const APPROVED = 1;
    const PENDING_APPROVAL = 0;
    const DENIED = -1;
    const ESCALATED = -2;

    public static $statuses = [
        self::APPROVED => 'Approved',
        self::DENIED => 'Denied',
        self::PENDING_APPROVAL => 'Pending Approval',
        self::ESCALATED => 'Escalated',
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

    public function escalate()
    {
        if ($this->status != static::PENDING_APPROVAL || !$this->shouldSend()) return false;
        
        $manager = $this->approver->manager;

        if ($manager) {
            $attributes = $this->getOriginal();
            unset($attributes['id'], $attributes['created_at'], $attributes['updated_at']);
            $attributes['approver_id'] = $manager->id;
            static::unguard(true);
            static::create($attributes);
            status::unguard(false);
            $this->update(['status' => static::ESCALATED]);
        } else {
            dispatch(new SendApproval($this));
        }

        return true;
    }

    public function shouldSend()
    {
        $pendingCount = $this->ticket->approvals()
            ->where('stage', '<', $this->stage ?? 0)
            ->where('status', static::PENDING_APPROVAL)
            ->count();

        return $pendingCount == 0;
    }

    public function hasNext()
    {
        return $this->ticket->approvals()->where('stage', '>', $this->stage)->count() > 0;
    }

    public function getNextStageApprovals()
    {
        $nextApprovals = $this->ticket->approvals()->where('stage', '>', $this->stage)->get();
        $approvals = collect();
        $previous = 0;

        /** @var TicketApproval $approval */
        foreach ($nextApprovals as $approval) {
            if ($previous && $approval->stage != $previous) {
                break;
            }

            $approvals->push($approval);
            $previous = $approval->stage;
        }

        return $approvals;
    }

    function getPendingAttribute()
    {
        return $this->status == static::PENDING_APPROVAL;
    }
    function getApprovalStatusAttribute(){
        return array_get(self::$statuses,$this->status);
    }

    function getResendAttribute(){
        $approvals = TicketLog::where('ticket_id',$this->ticket->id)->where('type',TicketLog::RESEND_APPROVAL)->get();
        $count = 0;
        foreach ($approvals as $approval){
            if(isset($approval->new_data['approval_id']) && $this->id == $approval->new_data['approval_id']){
                $count++;
            }
        }
        return $count;
    }

    function getActionDateAttribute(){
        if($this->status != 0){
            return $this->approval_date->format('d/m/Y h:i A');
        }
    }

    function getApprovalIconAttribute(){
        if($this->status == self::APPROVED) {
            return 'check';
        }elseif ($this->status == self::DENIED)  {
            return 'times';
        }
        return 'spinner';
    }
                                                                                                                                                                                        
    function getApprovalColorAttribute(){
        if($this->status == self::APPROVED) {
            return 'success';
        }elseif ($this->status == self::DENIED)  {
            return 'danger';
        }
        return '';
    }

}
