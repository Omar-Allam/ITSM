<?php

namespace App\Http\Controllers;

use App\BusinessUnit;
use App\Category;
use App\Http\Requests;
use App\Impact;
use App\Item;
use App\Location;
use App\Priority;
use App\Subcategory;
use App\Urgency;

class ListController extends Controller
{
    public function subcategory($cat_id = false)
    {
        $query = Subcategory::query();

        if ($cat_id) {
            $query->where('category_id', $cat_id);
        }

        return $query->selection();
    }

    public function item($subcat_id = false)
    {
        $query = Item::query();

        if ($subcat_id) {
            $query->where('subcategory_id', $subcat_id);
        }

        return $query->selection();
    }

    public function category()
    {
        return Category::selection();
    }

    public function location()
    {
        return Location::selection();
    }

    public function businessUnit()
    {
        return BusinessUnit::selection();
    }

    public function priority()
    {
        return Priority::selection();
    }

    public function urgency()
    {
        return Urgency::selection();
    }

    public function impact()
    {
        return Impact::selection();
    }
}
