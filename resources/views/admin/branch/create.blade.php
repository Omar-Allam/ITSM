@extends('layouts.app')

@section('header')
    <h4>Add Branch</h4>
    <a href="{{route('admin.branch.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{Form::open(['route' => 'admin.branch.store', 'class' => 'col-sm-9'])}}

    @include('admin.branch._form')

    {{Form::close()}}
@stop