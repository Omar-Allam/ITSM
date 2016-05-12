<?php

namespace App;

use App\Behaviors\Listable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Subcategory
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Item[] $items
 * @property-read \App\Category $category
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subcategory selection($empty = false)
 * @mixin \Eloquent
 */
class Subcategory extends KModel
{
    use Listable;
    
    protected $fillable = ['category_id', 'name', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class, 'subcategory_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeCanonicalList(Builder $query)
    {
        $subcategories = $query->with('category')
            ->orderBy('name')
            ->get();

        $list = [];

        foreach ($subcategories as $subcategory) {
            $list[$subcategory->id] = $subcategory->category->name . ' > ' . $subcategory->name;
        }

        asort($list);

        return collect($list);
    }
}
