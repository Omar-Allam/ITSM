@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Region</h4>

    <form action="{{route('admin.region.destroy', $region)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.region.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($region, ['route' => ['admin.region.update', $region]])}}

    {{method_field('patch')}}

    @include('admin.region._form')

    {{Form::close()}}
@stop