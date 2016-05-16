@extends('layouts.app')

@section('header')
    <h4>#{{$ticket->id}} - {{$ticket->subject}}</h4>
@endsection

@section('body')
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#main" role="tab" data-toggle="tab">Request</a></li>
        <li class="active"><a href="#main" role="tab" data-toggle="tab">Request</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="main">
            @include('ticket.tabs._main')
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">

        </div>
    </div>
@endsection