<?php

namespace App;

class Ticket extends Model
{
    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];
}