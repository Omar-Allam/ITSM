@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Business rule</h4>

    <a href="{{ route('admin.business-rule.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.business-rule.store']) }}

        @include('admin.business-rule._form')

    {{ Form::close() }}
@stop
