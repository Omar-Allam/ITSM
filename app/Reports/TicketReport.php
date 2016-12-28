<?php

namespace App\Reports;

use App\Ticket;

class TicketReport
{
    protected $fields;
    protected $filter;
    protected $group;
    protected $order;

    protected $query;

    function __construct()
    {
        $this->query = Ticket::query();
        $this->fields = new TicketFields($this->query);
        $this->filter = new TicketFilters($this->query);
        $this->group = new TicketGroup($this->query);
        $this->order = new TicketOrder($this->query);
    }

    function select($fields = [])
    {
        foreach ($fields as $field) {
            $this->fields->select($field);
        }

        return $this;
    }

    function filter($criteria)
    {
        foreach ($criteria as $criterion) {
            $value = explode(',', $criterion['value']);
            if (count($value) == 1) {
                $value = $value[0];
            }
            $criterion['value'] = $value;

            $this->filter->addCriteria($criterion);
        }

        return $this;
    }

    function groupBy($fields)
    {
        foreach ($fields as $field) {
            $this->group->by($field);
        }

        return $this;
    }

    function orderBy($fields)
    {
        foreach ($fields as $field) {
            $this->order->by($field);
        }

        return $this;
    }

    function get($perPage = 25)
    {
        $result = $this->query->paginate($perPage);
        $this->query = Ticket::query();
        return $result;
    }
}