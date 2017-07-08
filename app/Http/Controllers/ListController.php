<?php

namespace App\Http\Controllers;

use App\BusinessUnit;
use App\Category;
use App\Group;
use App\Http\Requests;
use App\Impact;
use App\Item;
use App\Location;
use App\Priority;
use App\Status;
use App\Subcategory;
use App\Ticket;
use App\Urgency;
use App\User;

class ListController extends Controller
{
    public function subcategory($cat_id = false)
    {
        $query = Subcategory::query();

        if ($cat_id) {
            return $query->where('category_id', $cat_id)->selection();
        }

        return $query->canonicalList();
    }

    public function item($subcat_id = false)
    {
        $query = Item::query();

        if ($subcat_id) {
            return $query->where('subcategory_id', $subcat_id)->selection();
        }

        return $query->canonicalList();
    }

    public function category()
    {
        return Category::orderBy('name')->selection();
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

    public function supportGroup()
    {
        return Group::support()->pluck('name', 'id')->sort();
    }

    public function technician()
    {
        return User::technicians()->pluck('name', 'id')->sort();
    }

    function requester()
    {
        return User::orderBy('name')->pluck('name', 'id');
    }

    function status()
    {
        return Status::orderBy('name')->pluck('name', 'id');
    }

    function technicians($group=false)
    {
        $query = User::query();

        $techs = collect(\DB::select('SELECT user_id FROM group_user WHERE group_id=' . $group))->pluck('user_id');
        if ($group) {
            return $query->whereIn('id', $techs)->selection();
        }
        return $query->canonicalList();
    }
}
