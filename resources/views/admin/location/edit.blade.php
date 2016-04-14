@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Location</h4>

    <form action="{{route('admin.location.destroy', $location)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.location.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($location, ['route' => ['admin.location.update', $location]])}}

    {{method_field('patch')}}

    @include('admin.location._form')

    {{Form::close()}}
@stop