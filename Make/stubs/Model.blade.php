{!! '<' !!}?php

namespace App;

class {{$className}} extends Model
{
    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];
}