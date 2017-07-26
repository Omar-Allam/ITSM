@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Users</h4>
    <div class="heading-actions pull-right">
        <form action="" class="form-inline" method="get">
            <div class="input-group">
                <input class="form-control input-sm" type="search" name="q" id="searchTerm" placeholder="Search"
                       value="{{Request::query('q', '')}}">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
                </span>
            </div>
            {{--<a title="Import from active directory" href="#ImportModal" data-toggle="modal" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>--}}
            <a href="{{ route('admin.user.create') }} " class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>
        </form>
    </div>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
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
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.user.edit', $user) }} "><i
                                            class="fa fa-edit"></i> Edit</a>
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

    </section>
@stop
