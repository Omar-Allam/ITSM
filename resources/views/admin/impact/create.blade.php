@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Impact</h4>

    <a href="{{ route('admin.impact.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.impact.store']) }}

        @include('admin.impact._form')

    {{ Form::close() }}
@stop
