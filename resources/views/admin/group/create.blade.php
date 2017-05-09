@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Group</h4>

    <a href="{{ route('admin.group.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{ Form::open(['route' => 'admin.group.store', 'class' => 'col-sm-9']) }}

        @include('admin.group._form')

    {{ Form::close() }}
@stop
