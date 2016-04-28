@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Impact</h4>

    <form action="{{ route('admin.impact.destroy', $impact)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.impact.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($impact, ['route' => ['admin.impact.update', $impact]]) }}

        {{ method_field('patch') }}

        @include('admin.impact._form')

    {{ Form::close() }}
@stop
