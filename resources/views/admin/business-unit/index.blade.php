@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Business Units</h4>
    <a href="{{route('admin.business-unit.create')}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($businessUnits->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Default Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($businessUnits as $businessUnit)
                <tr>
                    <td class="col-md-5"><a href="{{route('admin.business-unit.edit', $businessUnit)}}">{{$businessUnit->name}}</a></td>
                    <td class="col-md-4">{{$businessUnit->location->name or ''}}</td>
                    <td class="col-md-3">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.business-unit.edit', $businessUnit)}}"><i class="fa fa-edit"></i> Edit</a>
                        <form action="{{route('admin.business-unit.destroy', $businessUnit)}}" method="post" class="inline-block">
                            {{csrf_field()}} {{method_field('delete')}}
                            <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $businessUnits])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No branches found</strong></div>
    @endif
@stop