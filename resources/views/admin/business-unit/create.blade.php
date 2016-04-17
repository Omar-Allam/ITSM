@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Business Unit</h4>
    <a href="{{route('admin.business-unit.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => ['admin.business-unit.store']])}}

    @include('admin.business-unit._form')

    {{Form::close()}}
@stop