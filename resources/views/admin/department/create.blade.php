@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Department</h4>

    <a href="{{route('admin.department.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.department.store'])}}

    @include('admin.department._form')

    {{Form::close()}}
@stop