@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Categories - {{$category->name}}</h4>

    <div class="pull-right">
        <a href="{{route('admin.category.edit', $category)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
        <a href="{{route('admin.category.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
    </div>
@endsection

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
        @if ($category->description)
            {!! nl2br(e($category->description)) !!}
        @endif

        <h4>Subcategories</h4>

        <p class="clearfix">
            <a href="{{route('admin.subcategory.create')}}?category={{$category->id}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add subcategory</a>
        </p>

        @if ($category->subcategories->count())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Subcategory</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($category->subcategories as $subcategory)
            <tr>
                <td><a href="{{route('admin.subcategory.show', $subcategory)}}">{{$subcategory->name}}</a></td>
                <td>
                    {{Form::open(['route' => ['admin.subcategory.destroy', $subcategory], 'method' => 'delete'])}}
                    <a class="btn btn-xs btn-primary" href="{{route('admin.subcategory.edit', $subcategory)}}"><i class="fa fa-edit"></i> Edit</a>
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
                No subcategories found
            </div>
        @endif
    </section>
@endsection