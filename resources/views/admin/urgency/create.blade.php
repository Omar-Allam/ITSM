@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Urgency</h4>

    <a href="{{ route('admin.urgency.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.urgency.store']) }}

        @include('admin.urgency._form')

    {{ Form::close() }}
@stop
