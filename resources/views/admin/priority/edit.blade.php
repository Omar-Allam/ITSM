@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Priority</h4>

    <form action="{{ route('admin.priority.destroy', $priority)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.priority.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($priority, ['route' => ['admin.priority.update', $priority], 'class' => 'col-sm-9']) }}

        {{ method_field('patch') }}

        @include('admin.priority._form')

    {{ Form::close() }}
@stop
