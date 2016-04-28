{{'@'}}extends('layouts.app')

{{'@'}}section('header')
    <h4 class="pull-left">Add {{$humanUp}}</h4>

    <a href="{{'{{'}} route('{{$viewPrefix}}.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
{{'@'}}stop

{{'@'}}section('body')
    {{'{{'}} Form::open(['route' => '{{$viewPrefix}}.store']) }}

        {{'@'}}include('{{$viewPrefix}}._form')

    @{{ Form::close() }}
{{'@'}}stop
