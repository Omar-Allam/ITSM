<?php

namespace App\Helpers\Ticket;


use App\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TicketFilter
{
    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var array
     */
    protected $criteria;

    static protected $requesterFields = [];
    static protected $technicianFields = [];

    public function __construct(Builder $query, $criteria)
    {
        $this->query = $query;
        $this->criteria = $criteria;
    }


    public function apply()
    {
        foreach ($this->criteria as $criterion) {
            $this->applyCriterion($criterion);
        }

        return $this->query;
    }

    protected function applyCriterion($criterion)
    {
//        if (in_array($criterion['field'], static::$requesterFields)) {
//            call_user_func_array([$this, 'has_requester_' . $criterion['operator']], [$criterion]);
//        } elseif (in_array($criterion['field'], static::$technicianFields)) {
//            call_user_func_array([$this, 'has_technician_' . $criterion['operator']], [$criterion]);
//        } else {
            call_user_func_array([$this, $criterion['operator']], [$criterion]);
//        }
    }

    protected function is($criterion)
    {
        if ($criterion['value']) {
            $this->query->whereIn($criterion['field'], explode(',', $criterion['value']));
        } else {
            $this->query->where(function ($q) use ($criterion) {
                $q->where($criterion['field'], '')->orWhereNull($criterion['field']);
            });
        }
    }

    protected function isnot($criterion)
    {
        if ($criterion['value']) {
            $this->query->whereNotIn($criterion['field'], explode(',', $criterion['value']));
        } else {
            $this->query->whereNot(function ($q) use ($criterion) {
                $q->where($criterion['field'], '')->orWhereNull($criterion['field']);
            });
        }
    }

    protected function contains($criterion)
    {
        if ($criterion['value']) {
             if (Str::endsWith($criterion['field'], '_id')) {
                $relation = Str::replaceLast('_id', '', $criterion['field']);
                $this->query->whereHas($relation, function (Builder $q) use ($criterion) {
                    $q->where('name', 'like', "%{$criterion['value']}%");
                });
            } else {
                $this->query->where($criterion['field'], 'like', "%{$criterion['value']}%");
            }
        }
    }

    protected function notcontain($criterion)
    {
        if ($criterion['value']) {
            if (Str::endsWith($criterion['field'], '_id')) {
                $relation = Str::replaceLast('_id', '', $criterion['field']);
                $this->query->whereHas($relation, function (Builder $q) use ($criterion) {
                    $q->where('name', 'not like', "%{$criterion['value']}%");
                });
            } else {
                $this->query->where($criterion['field'], 'not like', "%{$criterion['value']}%");
            }
        }
    }

    protected function starts($criterion)
    {
        if ($criterion['value']) {
            if (Str::endsWith($criterion['field'], '_id')) {
                $relation = Str::replaceLast('_id', '', $criterion['field']);
                $this->query->whereHas($relation, function (Builder $q) use ($criterion) {
                    $q->where('name', 'like', "{$criterion['value']}%");
                });
            } else {
                $this->query->where($criterion['field'], 'like', "{$criterion['value']}%");
            }
        }
    }

    protected function ends($criterion)
    {
        if ($criterion['value']) {
            if (Str::endsWith($criterion['field'], '_id')) {
                $relation = Str::replaceLast('_id', '', $criterion['field']);
                $this->query->whereHas($relation, function (Builder $q) use ($criterion) {
                    $q->where('name', 'like', "%{$criterion['value']}");
                });
            } else {
                $this->query->where($criterion['field'], 'like', "%{$criterion['value']}");
            }
        }
    }

}