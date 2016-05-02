@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Service Level Agreement</h4>

    <form action="{{ route('admin.sla.destroy', $sla)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.sla.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($sla, ['route' => ['admin.sla.update', $sla]]) }}

        {{ method_field('patch') }}

        @include('admin.sla._form')

    {{ Form::close() }}
@stop
