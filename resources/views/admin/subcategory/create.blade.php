@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Subcategory</h4>

    <a href="{{route('admin.subcategory.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{Form::open(['route' => 'admin.subcategory.store', 'class' => 'col-sm-9'])}}

    @include('admin.subcategory._form')

    {{Form::close()}}
@stop
