@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Category</h4>

    <form action="{{route('admin.category.destroy', $category)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.category.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($category, ['route' => ['admin.category.update', $category]])}}

    {{method_field('patch')}}

    @include('admin.category._form')

    {{Form::close()}}
@stop