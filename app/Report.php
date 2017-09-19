<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [];

    protected $casts = ['parameters' => 'array'];

    function scopeFilter(Builder $query)
    {

    }

    function core_report()
    {
        return $this->belongsTo(CoreReport::class);
    }

}
