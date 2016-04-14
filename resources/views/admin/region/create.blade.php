@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Region</h4>

    <a href="{{route('admin.region.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.region.store'])}}

    @include('admin.region._form')

    {{Form::close()}}
@stop