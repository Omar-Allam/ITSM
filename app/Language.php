<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['id', 'language'];

    function translations()
    {
        return $this->belongsToMany(Language::class);
    }
}
