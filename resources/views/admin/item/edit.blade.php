@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Item</h4>

    <form action="{{route('admin.item.destroy', $item)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{route('admin.item.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{Form::model($item, ['route' => ['admin.item.update', $item], 'class' => 'col-sm-9'])}}

    {{method_field('patch')}}

    @include('admin.item._form')

    {{Form::close()}}
@stop
