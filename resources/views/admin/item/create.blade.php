@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Item</h4>

    <a href="{{route('admin.item.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.item.store'])}}

    @include('admin.item._form')

    {{Form::close()}}
@stop
