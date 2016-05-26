@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit User</h4>

    <form action="{{ route('admin.user.destroy', $user)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.user.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-remove"></i></button>
    </form>
@stop

@section('body')
    {{ Form::model($user, ['route' => ['admin.user.update', $user]]) }}

        {{ method_field('patch') }}

        @include('admin.user._form')

    {{ Form::close() }}
@stop
