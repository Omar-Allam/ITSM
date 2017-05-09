@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Items</h4>
    <a href="{{route('admin.item.create')}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
    @if ($items->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Subcategory</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td class="col-md-5"><a href="{{route('admin.item.edit', $item)}}">{{$item->name}}</a></td>
                    <td class="col-md-4">{{$item->subcategory->name}}</td>
                    <td class="col-md-3">
                        <form action="{{route('admin.item.destroy', $item)}}" method="post">
                            {{csrf_field()}} {{method_field('delete')}}
                            <a class="btn btn-sm btn-primary" href="{{route('admin.item.edit', $item)}}"><i class="fa fa-edit"></i> Edit</a>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $items])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No items found</strong></div>
    @endif
    </section>
@stop
