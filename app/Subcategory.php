<?php

namespace App;

use App\Behaviors\Listable;

class Subcategory extends Model
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
}
