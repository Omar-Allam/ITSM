{{'@'}}extends('layouts.app')

{{'@'}}section('header')
    <h4 class="pull-left">Edit {{$humanUp}}</h4>

    <form action="{{'{{'}} route('{{$viewPrefix}}.destroy', ${{$single}})}}" class="pull-right" method="post">
        @{{csrf_field()}} @{{method_field('delete')}}
        <a href="{{'{{'}} route('{{$viewPrefix}}.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
{{'@'}}stop

{{'@'}}section('body')
    {{'{{'}} Form::model(${{$single}}, ['route' => ['{{$viewPrefix}}.update', ${{$single}}]]) }}

        @{{ method_field('patch') }}

        {{'@'}}include('{{$viewPrefix}}._form')

    @{{ Form::close() }}
{{'@'}}stop
