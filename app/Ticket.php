<?php

namespace App;

use App\Helpers\Ticket\TicketViewScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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

    protected $fillable = [
        'subject', 'description', 'category_id', 'subcategory_id', 'item_id', 'group_id', 'technician_id',
        'priority_id', 'impact_id', 'urgency_id', 'requester_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'due_date', 'first_response_date', 'resolve_date', 'close_date'];

    /**
     * @var TicketReply
     */
    protected $resolution;

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
        return $this->hasMany(TicketApproval::class);
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
    
    public function scopeScopedView(Builder $query)
    {
        $scope = new TicketViewScope($query);
        $scope->apply();

        return $query;
    }

    public function isOpen()
    {
        return $this->status->type == Status::OPEN;
    }
}
