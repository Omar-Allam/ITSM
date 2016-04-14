@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Regions</h4>
    <a href="{{route('admin.region.create')}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($regions->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($regions as $region)
                <tr>
                    <td class="col-md-8"><a href="{{route('admin.region.edit', $region)}}">{{$region->name}}</a></td>
                    <td class="col-md-4">
                        <a class="btn btn-sm btn-primary" href="{{route('admin.region.edit', $region)}}"><i
                                    class="fa fa-edit"></i> Edit</a>
                        <form action="{{route('admin.region.destroy', $region)}}" method="post" class="inline-block">
                            {{csrf_field()}} {{method_field('delete')}}
                            <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $regions])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No regions found</strong></div>
    @endif
@stop