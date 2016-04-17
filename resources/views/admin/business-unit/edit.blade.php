@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Business Unit</h4>

    <form action="{{route('admin.business-unit.destroy', $businessUnit)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.business-unit.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($businessUnit, ['route' => ['admin.business-unit.update', $businessUnit]])}}

    {{method_field('patch')}}

    @include('admin.business-unit._form')

    {{Form::close()}}
@stop