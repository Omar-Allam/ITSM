<?php

namespace App;

class Ticket extends Model
{
    protected $fillable = [
        'subject',
        'description',
        'category_id',
        'subcategory_id',
        'item_id',
        'group_id',
        'technician_id',
        'priority_id',
        'impact_id',
        'urgency_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function requester()
    {
        return $this->belongsTo(User::class);
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
}