@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Branch</h4>

    <form action="{{route('admin.branch.destroy', $branch)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.branch.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{Form::model($branch, ['route' => ['admin.branch.update', $branch], 'class' => 'col-sm-8'])}}

    {{method_field('patch')}}

    @include('admin.branch._form')

    {{Form::close()}}
@stop