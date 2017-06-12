<?php

namespace App;

use App\Behaviors\Listable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Item
 *
 * @property integer $id
 * @property integer $subcategory_id
 * @property string $name
 * @property string $description
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Subcategory $subcategory
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereSubcategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Item selection($empty = false)
 * @mixin \Eloquent
 */
class Item extends KModel
{
    use Listable;
    
    protected $fillable = ['subcategory_id', 'name', 'description','service_request'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function scopeCanonicalList(Builder $query)
    {
        $items = $query->with('subcategory')->with('subcategory.category')
            ->get();

        $list = [];

        foreach ($items as $item) {
            $list[$item->id] = "{$item->subcategory->category->name} > {$item->subcategory->name} > {$item->name}";
        }

        asort($list);

        return collect($list);
    }
}
