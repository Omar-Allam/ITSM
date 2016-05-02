@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Business rule</h4>

    <form action="{{ route('admin.business-rule.destroy', $business_rule)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.business-rule.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($business_rule, ['route' => ['admin.business-rule.update', $business_rule]]) }}

        {{ method_field('patch') }}

        @include('admin.business-rule._form')

    {{ Form::close() }}
@stop
