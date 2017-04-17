<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Builder;

class TicketOrder
{
    /** @var Builder */
    protected $query;

    function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function by($field)
    {
        $functionName = 'orderBy' . Str::studly($field);
        if (method_exists($this, $functionName)) {
            call_user_func([$this, $functionName]);
        } else {
            $this->query->orderBy($field);
        }

        return $this;
    }
}