@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Group</h4>

    <a href="{{ route('admin.group.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.group.store']) }}

        @include('admin.group._form')

    {{ Form::close() }}
@stop
