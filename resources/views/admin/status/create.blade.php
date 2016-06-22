@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Status</h4>

    <a href="{{ route('admin.status.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.status.store']) }}

        @include('admin.status._form')

    {{ Form::close() }}
@stop
