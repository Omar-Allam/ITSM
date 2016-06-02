@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Business Unit</h4>

    <form action="{{route('admin.business-unit.destroy', $business_unit)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.business-unit.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($business_unit, ['route' => ['admin.business-unit.update', $business_unit]])}}

    {{method_field('patch')}}

    @include('admin.business-unit._form')

    {{Form::close()}}
@stop