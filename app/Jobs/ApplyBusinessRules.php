<?php

namespace App\Jobs;

use App\BusinessRule;
use App\Criteria;
use App\Ticket;

class ApplyBusinessRules extends MatchCriteria
{
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle()
    {
        if (!$this->ticket->shouldApplyRules()) {
            return false;
        }

        $rules = BusinessRule::with('criterions')->with('rules')->get();

        foreach ($rules as $rule) {
            if ($this->match($rule)) {
                $this->applyRule($rule);

                if ($rule->is_last) {
                    break;
                }
            }
        }

        $this->ticket->stopLog(true)->setApplyRules(false);
        $this->ticket->save();
    }

    private function applyRule($rule)
    {
        foreach ($rule->rules as $action) {
            $this->ticket->setAttribute($action->field, $action->value);
        }
    }
}
