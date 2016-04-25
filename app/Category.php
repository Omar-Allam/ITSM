<?php

namespace App;

use App\Behaviors\Listable;

class Category extends Model
{
    use Listable;

    protected $fillable = ['name', 'description'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }
}
