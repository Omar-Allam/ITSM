<?php

namespace App;

class BusinessRule extends Model
{
    protected $fillable = ['name', 'description', 'is_last'];

    protected $dates = ['created_at', 'updated_at'];

    public function criteria()
    {
        $this->hasMany(Critiera::class, 'relation_id', 'id')->where('relation', 'rule');
    }
}
