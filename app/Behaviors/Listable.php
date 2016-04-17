<?php
namespace App\Behaviors;
use Illuminate\Database\Eloquent\Builder;

/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 4/17/16
 * Time: 11:25 AM
 */
trait Listable
{

    public function scopeSelection(Builder $query, $empty = false)
    {
        if (isset($this->displayField)) {
            $displayField = $this->displayField;
        } elseif (in_array('name', $this->fillable)) {
            $displayField = 'name';
        } elseif (in_array('title', $this->fillable)) {
            $displayField = 'title';
        } else {
            return [];
        }

        $list = $query->pluck($displayField, 'id');

        if ($empty !== false) {
            $list->prepend($empty, '');
        }

        return $list->toArray();
    }

}