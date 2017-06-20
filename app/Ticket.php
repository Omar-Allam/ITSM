<?php

namespace App;

use App\Helpers\Ticket\TicketFilter;
use App\Helpers\Ticket\TicketViewScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * App\Ticket
 *
 * @property integer $id
 * @property integer $requester_id
 * @property integer $creator_id
 * @property integer $coordinator_id
 * @property integer $technician_id
 * @property integer $group_id
 * @property string $subject
 * @property string $description
 * @property integer $category_id
 * @property integer $subcategory_id
 * @property integer $item_id
 * @property integer $status_id
 * @property integer $priority_id
 * @property integer $impact_id
 * @property integer $urgency_id
 * @property integer $sla_id
 * @property \Carbon\Carbon $due_date
 * @property \Carbon\Carbon $first_response_date
 * @property \Carbon\Carbon $resolve_date
 * @property \Carbon\Carbon $close_date
 * @property integer $business_unit_id
 * @property integer $location_id
 * @property integer $time_spent
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $requester
 * @property-read \App\User $technician
 * @property-read \App\Category $category
 * @property-read \App\Status $status
 * @property-read \App\Sla $sla
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereRequesterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCreatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCoordinatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTechnicianId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereSubject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereSubcategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereItemId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket wherePriorityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereImpactId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUrgencyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereSlaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereDueDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereFirstResponseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereResolveDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCloseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereBusinessUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTimeSpent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ticket extends KModel
{
    protected $stopLog = false;

    protected $shouldApplySla = true;

    protected $fillable = [
        'subject', 'description', 'category_id', 'subcategory_id', 'item_id', 'group_id', 'technician_id',
        'priority_id', 'impact_id', 'urgency_id', 'requester_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'due_date', 'first_response_date', 'resolve_date', 'close_date'];

    /**
     * @var TicketReply
     */
    protected $resolution;

    /**
     * @var Collection
     */
    protected $attachments;

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
    public function urgency()
    {
        return $this->belongsTo(Urgency::class);
    }

    public function impact()
    {
        return $this->belongsTo(Impact::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function sla()
    {
        return $this->belongsTo(Sla::class);
    }

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function approvals()
    {
        $relation = $this->hasMany(TicketApproval::class);
        $relation->orderBy('stage');
        return $relation;
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class);
    }

    public function getResolutionAttribute()
    {
        if (!$this->resolution) {
            $this->resolution = $this->replies()->where('status_id', 7)->first();
        }

        return $this->resolution;
    }

    public function hasPendingApprovals()
    {
        return $this->approvals()->where('status', TicketApproval::PENDING_APPROVAL)->count() > 0;
    }

    public function getDirtyOriginals()
    {
        if (!$this->isDirty()) {
            return [];
        }

        $attributes = [];
        $updated = array_keys($this->getDirty());

        foreach ($updated as $item) {
            $attributes[$item] = $this->getOriginal($item);
        }

        return $attributes;
    }

    public function stopLog($enable = null)
    {
        if (is_null($enable)) {
            return $this->stopLog;
        }

        $this->stopLog = $enable;

        return $this;
    }
    
    public function scopeScopedView(Builder $query, $scope)
    {
        $viewScope = new TicketViewScope($query);
        $viewScope->apply($scope);

        return $query;
    }

    public function scopeFilter(Builder $query, $criteria)
    {
        $filter = new TicketFilter($query, $criteria);
        $filter->apply();

        return $query;
    }

    public function isOpen()
    {
        return !$this->status || $this->status->type == Status::OPEN;
    }

    public function getFilesAttribute()
    {
        if (!$this->attachments) {
            $attachments = Attachment::where('type', Attachment::TICKET_TYPE)
                ->where('reference', $this->id)
                ->get();

            $replyAttachments = Attachment::where('type', Attachment::TICKET_REPLY_TYPE)
                ->whereIn('reference', $this->replies->pluck('id')->toArray())
                ->get();

            $this->attachments = $attachments->merge($replyAttachments);
        }

        return $this->attachments;
    }

    public function hasApprovalStages()
    {
        if ($this->approvals->count() < 2) {
            return false;
        }

        return $this->approvals->pluck('stage', 'stage')->count() > 1;
    }

    public function approvalStages()
    {
        return $this->approvals->pluck('stage', 'stage');
    }

    public function nextApprovalStage()
    {
        if ($this->approvals->count()) {
            return $this->approvals()->max('stage') + 1;
        }

        return 1;
    }

    public function syncFields($fields)
    {
        $customFields = collect();
        foreach ($fields as $custom_field_id => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }

            $customFields->push(compact('custom_field_id', 'value'));
        }
        $this->fields()->createMany($customFields->toArray());
    }

    function fields()
    {
        return $this->hasMany(TicketCustomField::class);
    }

    function tasks(){
        return $this->hasMany(Task::class);
    }

    function scopePending(Builder $query)
    {
        $query->whereHas('status', function(Builder $q){
            $q->whereIn('type', [Status::OPEN, Status::PENDING]);
        });
    }

    function getStartTimeAttribute()
    {
        $critical = $this->sla->critical ?? false;
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

    /**
     * Filters only tickets that is connected to SDP
     * @param Builder $query
     */
    function scopeHasSdp(Builder $query)
    {
        $query->whereNotNull('sdp_id');
    }

    public function setApplySla($value)
    {
        $this->shouldApplySla = $value;

        return $this;
    }

    public function shouldApplySla()
    {
        return $this->shouldApplySla;
    }
}
