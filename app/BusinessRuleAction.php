<?php

namespace App;

class BusinessRuleAction extends KModel
{
    protected $fillable = ['field', 'label', 'value'];

    public function business_rule()
    {
        return $this->belongsTo(BusinessRule::class);
    }
}
