<?php

namespace App\Jobs;

use App\BusinessRule;
use App\Ticket;

class ApplyBusinessRules extends MatchCriteria
{
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        $rules = BusinessRule::with('criterions')->with('rules')->get();

        foreach ($rules as $rule) {
            if ($this->ruleMatches($rule)) {
                $this->applyRule($rule);

                if ($rule->is_last) {
                    break;
                }
            }
        }
    }

    private function ruleMatches($rule)
    {
        $criterions = $rule->criterions;

        foreach ($criterions as $criterion) {
            if (!$this->checkCriterion($criterion)) {
                return false;
            }
        }

        return true;
    }

    private function applyRule($rule)
    {
        foreach ($rule->rules as $action) {
            $this->ticket->setAttribute($action->field, $action->value);
        }

        $this->ticket->save();
    }
}
