@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Department</h4>

    <form action="{{route('admin.department.destroy', $department)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.department.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{Form::model($department, ['route' => ['admin.department.update', $department]])}}

    {{method_field('patch')}}

    @include('admin.department._form')

    {{Form::close()}}
@stop