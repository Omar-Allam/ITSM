@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Add Branch</h4>

    <a href="{{route('admin.branch.index')}}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{Form::open(['route' => 'admin.branch.store'])}}

    @include('admin.branch._form')

    {{Form::close()}}
@stop