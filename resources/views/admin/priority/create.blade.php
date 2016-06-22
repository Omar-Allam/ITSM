@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Priority</h4>

    <a href="{{ route('admin.priority.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.priority.store']) }}

        @include('admin.priority._form')

    {{ Form::close() }}
@stop
