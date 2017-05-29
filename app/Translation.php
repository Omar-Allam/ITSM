<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{


    function language(){
        return $this->belongsTo(Translation::class);
    }
}
