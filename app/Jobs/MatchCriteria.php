<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 5/19/16
 * Time: 12:13 PM
 */

namespace App\Jobs;


use App\Criteria;
use Illuminate\Support\Str;

abstract class MatchCriteria extends Job
{
    /**
     * @var \App\Ticket
     */
    protected $ticket;

    protected function is($attribute, $criterion)
    {
        $tokens = explode(',', $criterion->value);

        return in_array($attribute, $tokens);
    }

    protected function contains($attribute, $criterion)
    {
        return Str::contains(Str::lower($attribute), Str::lower($criterion->value));
    }

    protected function starts($attribute, $criterion)
    {
        return Str::startsWith(Str::lower($attribute), Str::lower($criterion->value));
    }

    protected function ends($attribute, $criterion)
    {
        return Str::endsWith(Str::lower($attribute), Str::lower($criterion->value));
    }

    protected function checkCriterion($criterion)
    {
        $result = false;
        $attribute = $this->ticket->getAttribute($criterion->field);
        switch ($criterion->operator) {
            case 'is':
                $result = $this->is($attribute, $criterion);
                break;
            case 'isnot':
                $result = !$this->is($attribute, $criterion);
                break;
            case 'contains':
                $result = $this->contains($attribute, $criterion);
                break;
            case 'notcontain':
                $result = !$this->contains($attribute, $criterion);
                break;
            case 'starts':
                $result = $this->starts($attribute, $criterion);
                break;
            case 'ends':
                $result = $this->ends($attribute, $criterion);
                break;
        }

        return $result;
    }

    protected function match($relation)
    {
        $criterions = $relation->criterions;

        foreach ($criterions as $criterion) {
            $result = $this->checkCriterion($criterion);
            if ($result && $criterion->criteria->type == Criteria::ANY) {
                return true;
            }

            if (!$result) {
                return false;
            }
        }

        return true;
    }

}