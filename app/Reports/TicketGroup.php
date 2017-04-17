<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Builder;

class TicketGroup
{
    /** @var Builder */
    protected $query;

    function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function select($field)
    {
        $functionName = 'groupBy' . Str::studly($field);
        if (method_exists($this, $functionName)) {
            call_user_func([$this, $functionName]);
        } else {
            $this->query->groupBy($field);
        }

        return $this;
    }
}