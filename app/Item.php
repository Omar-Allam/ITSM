<?php

namespace App;

use App\Behaviors\Listable;

class Item extends Model
{
    use Listable;
    
    protected $fillable = ['subcategory_id', 'name', 'description'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }
}
