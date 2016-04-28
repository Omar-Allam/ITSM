@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Group</h4>

    <form action="{{ route('admin.group.destroy', $group)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.group.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($group, ['route' => ['admin.group.update', $group]]) }}

        {{ method_field('patch') }}

        @include('admin.group._form')

    {{ Form::close() }}
@stop
