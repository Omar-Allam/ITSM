<?php

namespace App\Behaviors;

use App\Criteria;
use App\Criterion;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait HasCriteria
 *
 * @package App\Behaviors
 *
 * @property String criteriaType
 */
trait HasCriteria
{
    /**
     * @return HasMany
     */
    public function criteria()
    {
        return $this->hasMany(Criteria::class, 'relation_id', 'id')->where('relation', $this->criteriaType);
    }

    public function updateCriteria(Request $request)
    {
        /** @var Criteria $criteria */
        if (!$this->criteria()->count()) {
            $criteria = $this->criteria()->create(['relation' => $this->criteriaType]);
        } else {
            $criteria = $this->criteria()->first();
        }

        $criteria->update(['type' => $request->get('criteria_type')]);

        $criterions = $request->get('criterions');
        $criteria->criteria()->delete();
        foreach ($criterions as $criterion) {
            $criteria->criteria()->create($criterion);
        }

        return $criteria;
    }

    public function criterions()
    {
        return $this->hasManyThrough(Criterion::class, Criteria::class, 'relation_id')->where('relation', $this->criteriaType);
    }

    public function getCriteriaTypeAttribute()
    {
        return $this->criteria()->first()->type;
    }
}