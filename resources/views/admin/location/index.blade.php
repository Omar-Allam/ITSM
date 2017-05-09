@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Locations</h4>
    <a href="{{route('admin.location.create')}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
    @if ($locations->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($locations as $location)
                <tr>
                    <td class="col-md-5"><a href="{{route('admin.location.edit', $location)}}">{{$location->name}}</a></td>
                    <td class="col-md-3">{{$location->city->name}}</td>
                    <td class="col-md-3">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.location.edit', $location)}}"><i
                                    class="fa fa-edit"></i> Edit</a>
                        <form action="{{route('admin.location.destroy', $location)}}" method="post" class="inline-block">
                            {{csrf_field()}} {{method_field('delete')}}
                            <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $locations])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No locations found</strong></div>
    @endif
    </section>
@stop