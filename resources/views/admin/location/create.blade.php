@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Location</h4>

    <a href="{{route('admin.location.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{Form::open(['route' => 'admin.location.store', 'class' => 'col-sm-9'])}}

    @include('admin.location._form')

    {{Form::close()}}
@stop