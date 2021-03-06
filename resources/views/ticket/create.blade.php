@extends('layouts.app')

@section('header')
    <h4 class="pull-left">{{t('Add Ticket')}}</h4>

    <a href="{{ route('ticket.index') }}" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i></a>
@stop

@section('body')
    {{ Form::open(['route' => 'ticket.store', 'files' => true, 'class' => 'col-sm-12']) }}

        @include('ticket._form')

    {{ Form::close() }}
@stop
