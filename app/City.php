<?php

namespace App;

/**
 * @property mixed id
 */
class City extends Model
{
    protected $fillable = ['name', 'region_id'];

    public static function selectList($empty = false)
    {
        $list = static::query()->pluck('name', 'id');

        if ($empty !== false) {
            $list->prepend($empty, '');
        }

        return $list->toArray();
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
