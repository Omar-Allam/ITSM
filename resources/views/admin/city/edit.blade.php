@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit City</h4>

    <form action="{{route('admin.city.destroy', $city)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.city.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($city, ['route' => ['admin.city.update', $city]])}}

    {{method_field('patch')}}

    @include('admin.city._form')

    {{Form::close()}}
@stop