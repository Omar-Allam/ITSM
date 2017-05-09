@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add User</h4>

    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{ Form::open(['route' => 'admin.user.store', 'class' => 'col-sm-9']) }}

        @include('admin.user._form')

    {{ Form::close() }}
@stop
