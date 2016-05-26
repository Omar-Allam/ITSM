@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add User</h4>

    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.user.store']) }}

        @include('admin.user._form')

    {{ Form::close() }}
@stop
