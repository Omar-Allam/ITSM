@extends('layouts.app')

@section('header')
    <div class="row">
        <div class="col-md-9">
            <h4>#{{$ticket->id}} - {{$ticket->subject}}</h4>
            <div class="btn-toolbar">
                <button data-toggle="modal" data-target="#AssignForm" type="button" class="btn btn-sm btn-default" title="Re-assign"><i class="fa fa-mail-forward"></i> Re-assign</button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <ul class="list-unstyled">
                    <li><strong>Status:</strong> {{$ticket->status->name}}</li>
                    @if ($ticket->due_date)
                    <li><strong>Due Date:</strong> {{$ticket->due_date->format('d/m/Y H:i')}}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>


@endsection

@section('body')
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#main" role="tab" data-toggle="tab"><i class="fa fa-ticket"></i> Request</a></li>
        <li><a href="#conversation" role="tab" data-toggle="tab"><i class="fa fa-comments-o"></i> Conversation</a></li>
        <li><a href="#resolution" role="tab" data-toggle="tab"><i class="fa fa-support"></i> Resolution</a></li>
        <li><a href="#approvals" role="tab" data-toggle="tab"><i class="fa fa-check"></i> Approvals</a></li>
        <li><a href="#history" role="tab" data-toggle="tab"><i class="fa fa-history"></i> History</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="main">
            @include('ticket.tabs._main')
        </div>
        <div role="tabpanel" class="tab-pane" id="conversation">
            @include('ticket.tabs._conversation')
        </div>
        <div role="tabpanel" class="tab-pane" id="resolution">
            @include('ticket.tabs._resolution')
        </div>
        <div role="tabpanel" class="tab-pane" id="history">
            @include('ticket.tabs._history')
        </div>
        <div role="tabpanel" class="tab-pane" id="approvals">
            @include('ticket.tabs._approvals')
        </div>
    </div>

    @include('ticket._assign_modal')
@endsection

@section('javascript')
    <script src="{{asset('/js/ticket.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
@endsection