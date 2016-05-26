@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Users</h4>
    <a href="{{ route('admin.user.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($users->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Login</th>
                <th>Business Unit</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ route('admin.user.edit', $user) }}">{{ $user->name }}</a></td>
                    <td><a href="{{ route('admin.user.edit', $user) }}">{{ $user->login }}</a></td>
                    <td>{{ $user->business_unit->name or 'Not Assigned' }}</td>
                    <td>{{ $user->location->name or 'Not Assigned' }}</td>
                    <td class="col-md-2">
                        <form action="{{ route('admin.user.destroy', $user) }}" method="post">
                            {{csrf_field()}} {{method_field('delete')}}
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.user.edit', $user) }} "><i class="fa fa-edit"></i> Edit</a>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-remove"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $users])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No users found</strong></div>
    @endif
@stop
