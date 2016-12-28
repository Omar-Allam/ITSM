<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketCustomField extends Model
{
    protected $fillable = ['custom_field_id', 'ticket_id', 'value'];

    function custom_field()
    {
        return $this->belongsTo(CustomField::class);
    }
}
