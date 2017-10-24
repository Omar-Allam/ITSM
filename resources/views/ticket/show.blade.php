@extends('layouts.app')

@section('header')

    <div class="display-flex ticket-meta">
        <div class="flex">
            <h4>#{{$ticket->id}} - {{$ticket->subject}}</h4>

            <h4>@if($ticket->sdp_id) Helpdesk : #{{$ticket->sdp_id ?? ''}}  -  @endif<strong>{{t('By')}}
                    : {{$ticket->requester->name}}</strong></h4>
            @if($ticket->isDuplicated())
                <h4>{{'Duplicated Request from #'.$ticket->request_id.''}}
                    <a title="Show Original Request" href="{{route('ticket.show',$ticket->request_id)}}" target="_blank">
                        <i class="fa fa-external-link" aria-hidden="true"></i>
                    </a>
                </h4>
            @endif

            @if (Auth::user()->isSupport() && !$ticket->isTask())
                <div class="btn-toolbar">
                    <button data-toggle="modal" data-target="#AssignForm" type="button"
                            class="btn btn-sm btn-info btn-rounded btn-outlined" title="{{t('Re-assign')}}">
                        <i class="fa fa-mail-forward"></i> {{t('Re-assign')}}
                    </button>

                    <button data-toggle="modal" data-target="#DuplicateForm" type="button"
                            class="btn btn-sm btn-primary btn-rounded btn-outlined" title="Duplicate">
                        <i class="fa fa-copy"></i> {{t('Duplicate')}}
                    </button>


                    <button type="button" class="btn btn-primary btn-sm btn-rounded btn-outlined addNote"
                            data-toggle="modal" data-target="#ReplyModal" title="{{t('Add Note')}}">
                        <i class="fa fa-sticky-note"></i> {{t('Add Note')}}
                    </button>

                    @can('pick',$ticket)
                        <a href="{{route('ticket.pickup',$ticket)}}" title="Pick Up"
                           class="btn btn-sm btn-primary btn-rounded btn-outlined"><i
                                    class="fa fa-hand-lizard-o"></i> {{t('Pick Up')}}</a>
                    @endcan
                </div>
            @endif
        </div>


        <div class="card">
            <ul class="list-unstyled">
                <li>
                    @if($ticket->overdue)
                        <i class="fa fa-flag text-danger" aria-hidden="true"
                           title="{{t('SLA violated')}}"></i>
                    @endif
                    <small><strong>{{t('Status')}}:</strong> {{$ticket->status->name}}</small>
                </li>
                <li>
                    <small><strong>{{t('Created at')}}:</strong> {{$ticket->created_at->format('d/m/Y H:i')}}</small>
                </li>
                @if ($ticket->due_date)
                    <li>
                        <small><strong>{{t('Due Date')}} :</strong> {{$ticket->due_date->format('d/m/Y H:i')}}</small>
                    </li>
                @endif

                @if($ticket->resolve_date)
                    <li>
                        <small><strong>{{t('Resolve Date')}}:</strong> {{$ticket->resolve_date->format('d/m/Y H:i')}}
                        </small>
                    </li>
                @endif
                @if($ticket->last_updated_approval)
                    <li>
                        <small><strong>{{t('Approval Status')}}
                                :</strong> {{\App\TicketApproval::$statuses[$ticket->last_updated_approval->status]}}
                        </small>
                    </li>
                @endif
            </ul>

        </div>
    </div>

@endsection

@section('body')
    <section class="col-sm-12" id="ticketArea">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active">
                <a href="#main" role="tab" data-toggle="tab"><i
                            class="fa fa-ticket"></i>
                    @if(!$ticket->isTask())
                        {{t('Request')}}
                    @else
                        {{t('Task')}}
                    @endif

                </a>
            </li>
            <li><a href="#conversation" role="tab" data-toggle="tab"><i
                            class="fa fa-comments-o"></i> {{t('Conversation')}}</a></li>
            {{--<li><a href="#tasks" role="tab" data-toggle="tab"><i class="fa fa-tasks"></i> {{t('Tasks')}}</a></li>--}}
            @if ($ticket->resolution || can('resolve', $ticket))
                <li><a href="#resolution" role="tab" data-toggle="tab"><i
                                class="fa fa-support"></i> {{t('Resolution')}}</a></li>
            @endif
            @if (($ticket->approvals->count() || Auth::user()->isSupport()) && !$ticket->isTask())
                <li><a href="#approvals" role="tab" data-toggle="tab"><i
                                class="fa fa-check"></i> {{t('Approvals')}}</a></li>
            @endif

            @if(Auth::user()->isSupport() && !$ticket->isTask())
                <li><a href="#tasks" role="tab" data-toggle="tab"><i
                                class="fa fa-tasks"></i> {{t('Tasks')}}</a></li>
            @endif

            <li><a href="#history" role="tab" data-toggle="tab"><i
                            class="fa fa-history"></i>

                    @if(!$ticket->isTask())
                        {{t('Ticket Log')}}
                    @else
                        {{t('Ticket Log')}}
                    @endif
                </a></li>

            @if ($ticket->files->count())
                <li><a href="#attachments" role="tab" data-toggle="tab"><i
                                class="fa fa-file-o"></i> {{t('Attachments')}}</a></li>
            @endif
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


            @if ($ticket->files->count())
                <div role="tabpanel" class="tab-pane" id="attachments">
                    @include('ticket.tabs._attachment')
                </div>
            @endif

            <div role="tabpanel" class="tab-pane" id="tasks">
                @include('ticket.tabs.tasks')
            </div>

            <script>
                var category = '{{Form::getValueAttribute('category_id') ?? $ticket->category_id}}';
                var subcategory = '{{Form::getValueAttribute('subcategory_id') ?? $ticket->subcategory_id}}';
                var group = '{{Form::getValueAttribute('group_id') ?? $ticket->group_id}}';
            </script>
            <script src="{{asset('/js/tasks.js')}}"></script>
            @include('ticket._assign_modal')
            @include('ticket._notes_modal')
            @include('ticket._remove_note_modal')
            @include('ticket._duplicate_modal')
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{asset('/js/ticket.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymcebasic.min.js')}}"></script>

@endsection