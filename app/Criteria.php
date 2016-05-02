<?php

namespace App;

class Criteria extends Model
{
    protected $fillable = ['relation'];

    public function criteria()
    {
        return $this->hasMany(Criterion::class);
    }
}
