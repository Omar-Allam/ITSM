@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Branches</h4>
    <a href="{{route('admin.branch.create')}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($branches->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Business Unit</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($branches as $branch)
                <tr>
                    <td class="col-md-3"><a href="{{route('admin.branch.edit', $branch)}}">{{$branch->name}}</a></td>
                    <td class="col-md-3">{{$branch->business_unit->name}}</td>
                    <td class="col-md-3">{{$branch->location->name}}</td>
                    <td class="col-md-3">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.branch.edit', $branch)}}"><i class="fa fa-edit"></i> Edit</a>
                        <form action="{{route('admin.branch.destroy', $branch)}}" method="post" class="inline-block">
                            {{csrf_field()}} {{method_field('delete')}}
                            <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $branches])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No branches found</strong></div>
    @endif
@stop