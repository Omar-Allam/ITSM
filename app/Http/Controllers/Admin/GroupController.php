<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    protected $rules = ['name' => 'required', 'type' => 'required'];

    public function index()
    {
        $groups = Group::paginate();

        return view('admin.group.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.group.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save group');

        Group::create($request->all());

        flash('Group has been saved', 'success');

        return \Redirect::route('admin.group.index');
    }

    public function show(Group $group)
    {
        return view('admin.group.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('admin.group.edit', compact('group'));
    }

    public function update(Group $group, Request $request)
    {
        $this->validates($request, 'Could not save group');

        $group->update($request->all());

        flash('Group has been saved', 'success');

        return \Redirect::route('admin.group.index');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        flash('Group has been deleted', 'success');

        return \Redirect::route('admin.group.index');
    }

    public function addUser(Group $group, Request $request)
    {
        $this->validate($request, ['user_id' => 'required|exists:users,id']);

        $group->users()->attach($request->get('user_id'));

        flash('User has been added to group', 'success');

        return \Redirect::route('admin.group.show', $group);
    }

    public function removeUser(Group $group, User $user)
    {
        $group->users()->detach($user->id);

        flash('User has been removed from group', 'success');

        return \Redirect::route('admin.group.show', $group);
    }
}
