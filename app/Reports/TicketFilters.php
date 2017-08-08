<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TicketFilters
{
    /** @var Builder */
    protected $query;

    function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function addCriteria($criteria)
    {
        if (!$criteria['field']) {
            return $this;
        }

        $functionName = 'filter' . Str::studly($criteria['field']);
        if (method_exists($this, $functionName)) {
            call_user_func([$this, $functionName], $criteria);
        } else {
            $this->addWhere($criteria['field'], $criteria['operator'], $criteria['value']);
        }

        return $this;
    }

    protected function addWhere($field, $operator, $value)
    {
        if (method_exists($this, $operator)) {
            call_user_func([$this, $operator], $field, $value);
        } else {
            $this->is($field, $value);
        }

    }

    protected function is($field, $value)
    {
        if (is_array($value)) {
            $this->query->whereIn($field, $value);
        } else {
            $this->query->where($field, $value);
        }
    }

    protected function isNot($field, $value)
    {
        if (is_array($value)) {
            $this->query->whereNotIn($field, $value);
        } else {
            $this->query->where($field, '!=', $value);
        }
    }

    protected function starts($field, $value)
    {
        return $this->query->where($field, 'like', "{$value}%");
    }

    protected function ends($field, $value)
    {
        return $this->query->where($field, 'like', "%{$value}");
    }

    protected function contains($field, $value)
    {
        return $this->query->where($field, 'like', "%{$value}%");
    }

    protected function between($field, $value)
    {
        return $this->query->whereBetween($field, [$value['from'], $value['to']]);
    }

    protected function filterTechnician($criterion)
    {
        $this->addWhere('tec.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterRequester($criterion)
    {
        $this->addWhere('req.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterStatus($criterion)
    {
        $this->addWhere('st.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterBusinessUnit($criterion)
    {
        $this->addWhere('bu.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterLocation($criterion)
    {
        $this->addWhere('loc.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterCategory($criterion)
    {
        $this->addWhere('cat.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterSubcategory($criterion)
    {
        $this->addWhere('subcat.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterItem($criterion)
    {
        $this->addWhere('item.id', $criterion['operator'], $criterion['value']);
    }

    protected function filterCreatedAt($criterion)
    {
        $this->addWhere('tickets.created_at', $criterion['operator'], $criterion['value']);   
    }
}