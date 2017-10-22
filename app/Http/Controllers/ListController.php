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
            return $query->orderBy('name')->where('category_id', $cat_id)->get(['name', 'id']);
        }

        return $query->canonicalList();
    }

    public function item($subcat_id = false)
    {
        $query = Item::query();

        if ($subcat_id) {
            return $query->orderBy('name')->where('subcategory_id', $subcat_id)->selection();
        }

        return $query->canonicalList();
    }

    public function category()
    {
        return Category::orderBy('name')->get(['id', 'name']);
    }

    public function tasksCategory()
    {
        return Category::orderBy('name')->where('type',Ticket::TASK_TYPE)->get(['id', 'name']);
    }

    public function location()
    {
        return Location::orderBy('name')->get(['name', 'id']);
    }

    public function businessUnit()
    {
        return BusinessUnit::orderBy('name')->get(['name', 'id']);
    }

    public function priority()
    {
        return Priority::orderBy('name')->get(['name', 'id']);
    }

    public function urgency()
    {
        return Urgency::orderBy('name')->get(['name', 'id']);
    }

    public function impact()
    {
        return Impact::orderBy('name')->get(['name', 'id']);
    }

    public function supportGroup()
    {
        return Group::support()->orderBy('name')->get(['name', 'id']);
    }

    public function technician()
    {
        return User::technicians()->orderBy('name')->get(['name', 'id']);
    }

    function requester()
    {
        return User::orderBy('name')->get(['name', 'id']);
    }

    function status()
    {
        return Status::orderBy('name')->get(['name', 'id']);
    }

    function technicians($group=false)
    {
        $user_ids = \DB::table('group_user')->where('group_id', $group)->pluck('user_id');

        return User::technicians()->whereIn('id', $user_ids)->orderBy('name')->get(['name', 'id']);
    }
}
