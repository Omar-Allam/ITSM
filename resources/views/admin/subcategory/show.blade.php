@extends('layouts.app')

@section('header')
    <h4 class="pull-left">{{$subcategory->canonicalName()}}</h4>

    <div class="pull-right">
        <a href="{{route('admin.subcategory.edit', $subcategory)}}" class="btn btn-sm btn-primary"><i
                    class="fa fa-edit"></i></a>
        <a href="{{route('admin.category.show', $subcategory->category_id)}}" class="btn btn-sm btn-default"><i
                    class="fa fa-chevron-left"></i></a>
    </div>
@endsection

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
    @if ($subcategory->description)
        <p>{!! nl2br(e($subcategory->description)) !!}</p>
    @endif

    <h4>Items</h4>

    <p class="clearfix">
        <a href="{{route('admin.item.create')}}?subcategory={{$subcategory->id}}"
           class="pull-right btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add item</a>
    </p>

    @if ($subcategory->items->count())
    <table class="listing-table">
        <thead>
        <tr>
            <th>Item</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subcategory->items as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>
                    {{Form::open(['route' => ['admin.item.destroy', $item], 'method' => 'delete'])}}
                    <a class="btn btn-xs btn-primary" href="{{route('admin.item.edit', $item)}}"><i
                                class="fa fa-edit"></i> Edit</a>
                    <button type="submit" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i> Delete</button>
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-circle"></i>
            No items found
        </div>
    @endif
    </section>
@endsection