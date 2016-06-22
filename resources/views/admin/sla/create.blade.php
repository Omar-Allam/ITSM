@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Service Level Agreement</h4>

    <a href="{{ route('admin.sla.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'admin.sla.store']) }}

        @include('admin.sla._form')

    {{ Form::close() }}
@stop
