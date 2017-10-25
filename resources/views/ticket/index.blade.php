@extends('layouts.app')

@section('header')
    <h4 class="flex">{{t('Tickets')}}</h4>

    {{ Form::open(['route' => 'ticket.scope', 'class' => 'form-inline ticket-scope heading-actions flex']) }}
    <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
            {{t($scopes[$scope])}} &nbsp; <span class="count">{{\App\Ticket::scopedView($scope)->count()}}</span>
            &nbsp; <span class="caret"></span>
        </button>

        <ul class="dropdown-menu">
            @foreach ($scopes as $key => $value)
                <li>
                    <button class="btn btn-link btn-sm" type="submit" name="scope"
                            value="{{$key}}">{{t($value)}}</button>
                </li>
            @endforeach
        </ul>
    </div>
    {{ Form::close() }}

    {{Form::open(['route' => 'ticket.jump', 'class' => 'form-inline heading-actions'])}}
    <div class="input-group input-group-sm">
        <input class="form-control" type="text" name="id" id="ticketID" placeholder="{{t('Ticket ID')}}"/>
        <span class="input-group-btn">
            <button class="btn btn-default"><i class="fa fa-chevron-right"></i></button>
        </span>
    </div>
    {{--<a href="{{ route('ticket.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a>--}}
    <a href="#SearchForm" data-toggle="collapse" class="btn btn-info btn-sm"><i class="fa fa-search"></i></a>
    {{Form::close()}}
@stop

@section('body')
    <section class="col-sm-12" id="TicketList">
        @include('ticket._search_form')
        @if ($tickets->total())
            <table class="listing-table">
                <thead>
                <tr>
                    <th>{{t('ID')}}</th>
                    <th>{{t('Helpdesk ID')}}</th>
                    <th>{{t('Subject')}}</th>
                    <th>{{t('Requester')}}</th>
                    <th>{{t('Technician')}}</th>
                    <th>{{t('Created At')}}</th>
                    <th>{{t('Due Date')}}</th>
                    <th>{{t('Status')}}</th>
                    <th>{{t('Category')}}</th>
                    <th>{{t('Type')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td><a href="{{ route('ticket.show', $ticket) }}">{{ $ticket->id }}</a></td>
                        <td><a href="{{ route('ticket.show', $ticket) }}">{{ $ticket->sdp_id ?? ''}}</a></td>
                        <td>
                            @if($ticket->overdue)
                                <i class="fa fa-flag text-danger" aria-hidden="true" title="SLA violated"></i>
                            @endif
                                <a href="{{ route('ticket.show', $ticket) }}">{{ $ticket->subject }}</a>
                        </td>
                        <td>{{ $ticket->requester->name }}</td>
                        <td>{{ $ticket->technician? $ticket->technician->name : 'Not Assigned' }}</td>
                        <td>{{ $ticket->created_at->format('d/m/Y h:i a') }}</td>
                        <td>{{ $ticket->due_date? $ticket->due_date->format('d/m/Y h:i a') : t('Not Assigned') }}</td>
                        <td>{{ t($ticket->status->name) }}</td>
                        <td>{{ t($ticket->category->name) }}</td>
                        <td><i class="fa fa-{{t($ticket->type_icon)}}" title="{{t($ticket->type_name)}}" aria-hidden="true"></i></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @include('partials._pagination', ['items' => $tickets])
        @else
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No tickets found</strong>
            </div>
        @endif
    </section>
@stop

@section('javascript')
    <script src="{{asset('/js/ticket-index.js')}}"></script>
@endsection
