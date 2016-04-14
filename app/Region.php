<?php

namespace App;

class Region extends Model
{
    protected $fillable = ['name'];

    public static function selectList($empty = false)
    {
        $list = static::query()->pluck('name', 'id');

        if ($empty !== false) {
            $list->prepend($empty, '');
        }

        return $list->toArray();
    }


}
