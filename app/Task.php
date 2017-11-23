<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $table = 'tickets';
    protected $fillable = ['subject','description','category_id','subcategory_id','item_id','status_id','type','request_id'];

}
