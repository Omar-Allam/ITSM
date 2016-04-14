@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add City</h4>

    <a href="{{route('admin.city.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.city.store'])}}

    @include('admin.city._form')

    {{Form::close()}}
@stop