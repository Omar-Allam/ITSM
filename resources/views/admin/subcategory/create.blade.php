@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Subcategory</h4>

    <a href="{{route('admin.subcategory.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.subcategory.store'])}}

    @include('admin.subcategory._form')

    {{Form::close()}}
@stop
