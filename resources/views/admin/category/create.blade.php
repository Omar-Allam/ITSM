@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Category</h4>

    <a href="{{route('admin.category.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.category.store'])}}

    @include('admin.category._form')

    {{Form::close()}}
@stop