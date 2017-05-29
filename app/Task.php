<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ["id",
        "ticket_id",
        "status_id",
        "group_id",
        "technician_id",
        "type_id",
        "priority_id",
        "title",
        "description",
        "scheduled_start_from",
        "scheduled_start_to",
        "actual_start_from",
        "actual_start_to",
        "comments",
        "additional_cost",
        "created_at",
        "updated_at",];


    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class);
    }



}
