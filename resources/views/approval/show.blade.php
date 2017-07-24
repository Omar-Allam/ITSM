@extends('layouts.app')

@section('header')
    <h4 class="pull-left">#{{$ticketApproval->ticket->id}} - {{$ticketApproval->ticket->subject}} - Approval</h4>
    <div class="heading-actions pull-right">
        <a href="{{route('ticket.show', $ticketApproval->ticket)}}" class="btn btn-sm btn-info"
           title="Back to ticket" target="_blank"><i class="fa fa-ticket"></i> Display Ticket</a>
    </div>
@stop

@section('body')
    <section class="col-sm-6">
        <section id="ticket">
            <h4>Request Description</h4>
            <div class="well well-sm well-white">
                {!! $ticketApproval->ticket->description !!}
            </div>

            <h4>Approval Content</h4>
            <div class="well well-sm well-white">
                {!! $ticketApproval->content !!}
            </div>
        </section>

        <section id="action">
            {{Form::open(['route' => ['approval.update', $ticketApproval]])}}

            <h4>Action</h4>
            <div class="row form-group {{$errors->has('status')? 'has-error' : ''}}">
                <div class="col-md-3">
                    <label for="approve" class="radio-online">
                        {{Form::radio('status', \App\TicketApproval::APPROVED, null, ['id' => 'approve'])}}
                        Approve {{-- <i class="fa fa-thumbs-o-up"></i>--}}
                    </label>
                </div>
                <div class="col-md-3">
                    <label for="deny" class="radio-online">
                        {{Form::radio('status', \App\TicketApproval::DENIED, null, ['id' => 'deny'])}}
                        Deny {{--<i class="fa fa-thumbs-o-down"></i>--}}
                    </label>
                </div>
                <div class="col-md-12">
                    @if($errors->has('status'))
                        <div class="error-message">{{$errors->first('status')}}</div>
                    @endif
                </div>
            </div>

            <div class="form-group {{$errors->has('comment')? 'has-error' : ''}}">
                {{Form::label('comment', 'Comment', ['class' => 'control-label'])}}
                {{Form::textarea('comment', null, ['class' => 'form-control'])}}

                @if($errors->has('comment'))
                    <div class="error-message">{{$errors->first('comment')}}</div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i> Update</button>
            </div>

            {{Form::close()}}
        </section>
    </section>
    <section class="col-sm-6">
        <section class="ticket">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-user"></i> {{t('Requester Details')}}</h4>
                </div>
                <table class="table table-striped table-condensed">
                    <tr>
                        <th>{{t('Name')}}</th>
                        <td>{{$ticketApproval->ticket->requester->name}}</td>
                        <th>{{t('Business Unit')}}</th>
                        <td>{{$ticketApproval->ticket->requester->business_unit->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Email')}}</th>
                        <td>{{$ticketApproval->ticket->requester->email or 'Not Assigned'}}</td>
                        <th>{{t('Location')}}</th>
                        <td>{{$ticketApproval->ticket->requester->location->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Phone')}}</th>
                        <td>{{$ticketApproval->ticket->requester->phone or 'Not Assigned'}}</td>
                        <th>{{t('Mobile')}}</th>
                        <td>{{$ticketApproval->ticket->requester->mobile or 'Not Assigned'}}</td>
                    </tr>
                </table>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-ticket"></i> {{t('Request Details')}}</h4>
                </div>
                <table class="table table-striped table-condensed">
                    <tr>
                        <th>{{t('Category')}}</th>
                        <td>{{$ticketApproval->ticket->category->name or 'Not Assigned'}}</td>
                        <th>{{t('Subcategory')}}</th>
                        <td>{{$ticketApproval->ticket->subcategory->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Item')}}</th>
                        <td>{{$ticketApproval->ticket->Item->name or 'Not Assigned'}}</td>
                        <th>&nbsp;</th>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th>{{t('Urgency')}}</th>
                        <td>{{$ticketApproval->ticket->urgency->name or 'Not Assigned'}}</td>
                        <th>{{t('SLA')}}</th>
                        <td>{{$ticketApproval->ticket->sla->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Due Time')}}</th>
                        <td>{{$ticketApproval->ticket->due_date or 'Not Assigned'}}</td>
                        <th>{{t('First Response')}}</th>
                        <td>{{$ticketApproval->ticket->first_response_date or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Group')}}</th>
                        <td>{{$ticketApproval->ticket->group->name or 'Not Assigned'}}</td>
                        <th>{{t('Technician')}}</th>
                        <td>{{$ticketApproval->ticket->technician->name or 'Not Assigned'}}</td>
                    </tr>
                    <tr>
                        <th>{{t('Business Unit')}}</th>
                        <td>{{$ticketApproval->ticket->business_unit->name or 'Not Assigned'}}</td>
                        <th>{{t('Location')}}</th>
                        <td>{{$ticketApproval->ticket->location->name or 'Not Assigned'}}</td>
                    </tr>
                </table>
            </div>
            @if ($ticketApproval->ticket->fields->count())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-asterisk"></i> {{t('Additional Information')}}</h4>
                    </div>

                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                        @foreach($ticketApproval->ticket->fields as $field)
                            <tr>
                                <td class="col-sm-4 text-right"><strong>{{$field->name}}</strong></td>
                                <td>
                                    {{$field->value}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </section>
@stop