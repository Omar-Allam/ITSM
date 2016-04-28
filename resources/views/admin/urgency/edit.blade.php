@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Urgency</h4>

    <form action="{{ route('admin.urgency.destroy', $urgency)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.urgency.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($urgency, ['route' => ['admin.urgency.update', $urgency]]) }}

        {{ method_field('patch') }}

        @include('admin.urgency._form')

    {{ Form::close() }}
@stop
