@extends('layouts.app')

@section('header')
    @can('show',$ticket)
    <div class="display-flex ticket-meta">
        <div class="flex">
            <h4>#{{$ticket->id}} - {{$ticket->subject}}</h4>

            <h4>
                @if ($ticket->sdp_id) Helpdesk : #{{$ticket->sdp_id ?? ''}} &mdash; @endif

                <strong>{{t('By')}} :{{$ticket->requester->name}}</strong>
            </h4>

            @if($ticket->isDuplicated())
                <h4>{{'Duplicated Request from'}}:
                    <a title="Show Original Request" href="{{route('ticket.show',$ticket->request_id)}}"
                       target="_blank">
                        #{{ $ticket->request_id }}
                    </a>
                </h4>
            @endif

            @if (Auth::user()->isSupport())
                @if($ticket->isTask())
                    <h4>{{t('Request')}}:
                        <a title="{{ t('Show Original Request') }}" href="{{route('ticket.show',$ticket->request_id)}}"
                           target="_blank">
                            #{{ $ticket->request_id }}
                        </a>
                    </h4>
                @endif
                <div class="btn-toolbar">

                    @can('reassign',$ticket)
                    <button data-toggle="modal" data-target="#AssignForm" type="button"
                            class="btn btn-sm btn-info btn-rounded btn-outlined" title="{{t('Re-assign')}}">
                        <i class="fa fa-mail-forward"></i> {{t('Re-assign')}}
                    </button>
                    @endcan
                    
                    @if(!$ticket->isTask())
                        <button data-toggle="modal" data-target="#DuplicateForm" type="button"
                                class="btn btn-sm btn-primary btn-rounded btn-outlined" title="Duplicate">
                            <i class="fa fa-copy"></i> {{t('Duplicate')}}
                        </button>

                        <button type="button" class="btn btn-primary btn-sm btn-rounded btn-outlined addNote"
                                data-toggle="modal" data-target="#ReplyModal" title="{{t('Add Note')}}">
                            <i class="fa fa-sticky-note"></i> {{t('Add Note')}}
                        </button>

                        {{--@can('pick',$ticket)--}}
                            {{--<a href="{{route('ticket.pickup',$ticket)}}" title="Pick Up"--}}
                               {{--class="btn btn-sm btn-primary btn-rounded btn-outlined"><i--}}
                                        {{--class="fa fa-hand-lizard-o"></i> {{t('Pick Up')}}</a>--}}
                        {{--@endcan--}}
                    
                        <a href="{{route('ticket.print',$ticket)}}" target="_blank"
                           class="btn btn-sm btn-primary btn-rounded btn-outlined" title="Print">
                            <i class="fa fa-print"></i> {{t('Print')}}
                        </a>
                    @endif
                    @if($ticket->isTask())
                        @can('modify',$ticket)
                            <a href="{{route('tasks.edit',$ticket)}}"
                               class="btn btn-sm btn-primary btn-rounded btn-outlined" title="Edit">
                                <i class="fa fa-edit"></i> {{t('Edit')}}
                            </a>
                        @endcan
                    @endif
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
                        <small>
                            <strong>{{t('Approval Status')}}:</strong>
                            <i class="fa fa-lg fa-{{$ticket->last_updated_approval->approval_icon}} text-{{$ticket->last_updated_approval->approval_color}}" aria-hidden="true"></i> {{\App\TicketApproval::$statuses[$ticket->last_updated_approval->status]}}
                        </small>
                    </li>
                @endif
            </ul>

        </div>
    </div>
    @endcan
@endsection

@section('body')
    @if(can('show',$ticket))
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
                        {{t('Task Log')}}
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
    @else

        <div class="container-fluid">
            <div class="alert alert-warning text-center"><i class="fa fa-exclamation-circle"></i>
                <strong>
                    {{ t('You are not authorized to display this request') }}
                </strong>
            </div>
        </div>

    @endif
@endsection

@section('javascript')
    <script src="{{asset('/js/ticket.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymcebasic.min.js')}}"></script>

@endsection