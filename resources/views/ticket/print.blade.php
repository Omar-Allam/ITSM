@extends('layouts.print')
@section('body')


    <div class="container">
        <div class="back"><a href="{{route('ticket.show',$ticket)}}" class="btn btn-default"> <i
                        class="fa fa-chevron-left" aria-hidden="true"></i> {{t('Back to Ticket')}}
            </a>
        </div>

        <div class="print-ticket-form">
            <div class="panel panel-primary">
                <div class="panel-heading">{{t('Required Information')}}</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="checkbox">
                                <label> {{Form::checkbox('request-details',null,true,['id'=>'request-details'])}}{{t('Request Details')}}</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="checkbox">
                                <label> {{Form::checkbox('requester-details',null,true,['id'=>'requester-details'])}}{{t('Requester Details')}}</label>
                            </div>
                        </div>

                        @if ($ticket->replies->count())
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label> {{Form::checkbox('request-conversation',null,true,['id'=>'request-conversation'])}}{{t('Request Conversations')}}</label>
                                </div>
                            </div>
                        @endif

                        @if ($ticket->approvals->count())
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label> {{Form::checkbox('request-approvals',null,true,['id'=>'request-approvals'])}}{{t('Request Approvals')}}</label>
                                </div>
                            </div>
                        @endif
                        @if ($ticket->resolution)
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <label> {{Form::checkbox('request-resolution',null,true,['id'=>'request-resolution'])}}{{t('Request Resolution')}}</label>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <a class="btn btn-outlined btn-rounded btn-primary" id="printTicket" target="_parent">
                                <i class="fa fa-print"></i>{{t('Print')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="logo-image">
            <img src="{{asset('/images/logo.png')}}" class="logo-image">

        </div>

        <div class="print-ticket-basic">
            <div class="display-flex ticket-meta">
                <div class="flex">
                    <h4><strong>{{t('Request ID')}}</strong> : {{$ticket->id}}</h4>
                    <h4><strong>{{t('Subject')}}:</strong> : {{$ticket->subject}}</h4>

                    <h4>
                        @if ($ticket->sdp_id) <strong>Helpdesk</strong> : {{$ticket->sdp_id ?? ''}} &mdash; @endif
                        {{t('By')}} :{{$ticket->requester->name}}
                    </h4>
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
                            <small><strong>{{t('Created at')}}:</strong> {{$ticket->created_at->format('d/m/Y H:i')}}
                            </small>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{t('Description')}}</h4>
                </div>
                <div class="panel-body ticket-description">
                    {!! tidy_repair_string($ticket->description, [], 'utf8') !!}
                </div>
            </div>
        </div>

        <div class="print-ticket-details">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-ticket"></i>
                        @if(!$ticket->isTask())
                            {{t('Request Details')}}
                        @else
                            {{t('Task Details')}}
                        @endif
                    </h4>
                </div>
                <table class="table table-striped table-condensed">
                    <tr>
                        <th class="col-sm-3">{{t('Category')}}</th>
                        <td class="col-sm-3">{{$ticket->category->name or 'Not Assigned'}}</td>
                        <th class="col-sm-3">{{t('Subcategory')}}</th>
                        <td class="col-sm-3">{{$ticket->subcategory->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Item')}}</th>
                        <td>{{$ticket->Item->name or 'Not Assigned'}}</td>
                        <th>&nbsp;</th>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th>{{t('Urgency')}}</th>
                        <td>{{$ticket->urgency->name or 'Not Assigned'}}</td>
                        <th>{{t('SLA')}}</th>
                        <td>{{$ticket->sla->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Due Time')}}</th>
                        <td>{{$ticket->due_date or 'Not Assigned'}}</td>
                        <th>{{t('First Response Due Time')}}</th>
                        <td>{{$ticket->first_response_date or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Group')}}</th>
                        <td>{{$ticket->group->name or 'Not Assigned'}}</td>
                        <th>{{t('Technician')}}</th>
                        <td>{{$ticket->technician->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Business Unit')}}</th>
                        <td>{{$ticket->business_unit->name or 'Not Assigned'}}</td>
                        <th>{{t('Location')}}</th>
                        <td>{{$ticket->location->name or 'Not Assigned'}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="print-ticket-requester-details">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-user"></i> {{t('Requester Details')}}</h4>
                </div>
                <table class="table table-striped table-condensed">
                    <tr>
                        <th class="col-sm-3">{{t('Name')}}</th>
                        <td class="col-sm-3">{{$ticket->requester->name}}</td>
                        <th class="col-sm-3">{{t('Business Unit')}}</th>
                        <td class="col-sm-3">{{$ticket->requester->business_unit->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Email')}}</th>
                        <td>{{$ticket->requester->email or 'Not Assigned'}}</td>
                        <th>{{t('Location')}}</th>
                        <td>{{$ticket->requester->location->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Phone')}}</th>
                        <td>{{$ticket->requester->phone or 'Not Assigned'}}</td>
                        <th>{{t('Mobile')}}</th>
                        <td>{{$ticket->requester->mobile or 'Not Assigned'}}</td>
                    </tr>
                </table>
            </div>

        </div>
        @if ($ticket->replies->count())
            <div class="print-ticket-conversation">
                <h4 class="page-header"><i class="fa fa-comments-o"></i> {{t('Conversations')}} </h4>
                <section class="replies">
                    @foreach($ticket->replies()->whereNotIn('status_id',[7,9])->latest()->get() as $reply)
                        <div class="panel panel-sm panel-{{$reply->class}}">
                            <div class="panel-heading">
                                <h5 class="panel-title">{{t('By')}}
                                    : {{$reply->user->name}}
                                    On {{$reply->created_at->format('d/m/Y H:i A')}}</h5>
                            </div>
                            <div class="panel-body" id="reply{{$reply->id}}">
                                <div class="reply">
                                    {!! tidy_repair_string($reply->content, [], 'utf8') !!}
                                </div>
                                <br>
                                <span class="label label-default">Status: {{t($reply->status->name)}}</span>
                            </div>
                        </div>
                    @endforeach
                </section>

            </div>
        @endif

        @if ($ticket->approvals->count())
            <div class="print-ticket-approvals">
                <h4 class="page-header"><i class="fa fa-check"></i>{{t('Approvals')}}</h4>

                <div class="panel panel-warning">
                    @foreach($ticket->approvals as $approval)
                    <div class="panel-heading">
                        {{t('By: ') . $approval->created_by->name}}
                        {{t('On ').$approval->created_at->format('d/m/Y H:i A') }} {{t('To')}} {{$approval->approver->name}}
                    </div>
                    <div class="panel-body">
                      {!! tidy_repair_string($approval->content, [], 'utf8') !!}
                        <br>
                        <span class="label label-default">Status: {{App\TicketApproval::$statuses[$approval->status]}}</span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        @if ($ticket->resolution)
            <div class="print-ticket-resolution">
                <div class="panel panel-success">
                    <div class="panel-heading"><h4><i class="fa fa-support"></i> {{t('Resolution')}}</h4></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4"><p>Added by {{$ticket->resolution->user->name }}
                                    at {{$ticket->resolution->created_at->format('d/m/Y H:i:s')}}</p>
                            </div>
                        </div>

                        <div class="well well-sm well-white">
                            {!! tidy_repair_string($ticket->resolution->content,[],'utf8') !!}
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>

@endsection
@section('javascript')
    <script src="{{asset('/js/print.js')}}"></script>
@endsection