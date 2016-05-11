<?php

namespace App;

class Criterion extends Model
{
    protected $fillable = ['field', 'operator', 'value', 'label'];
}
