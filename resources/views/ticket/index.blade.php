@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Ticket</h4>
    <a href="{{ route('ticket.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($tickets->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Requester</th>
                <th>Technician</th>
                <th>Created At</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Category</th>
            </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td><a href="{{ route('ticket.show', $ticket) }}">{{ $ticket->id }}</a></td>
                        <td><a href="{{ route('ticket.show', $ticket) }}">{{ $ticket->subject }}</a></td>
                        <td>{{ $ticket->requester->name }}</td>
                        <td>{{ $ticket->technician? $ticket->technician->name : 'Not Assigned' }}</td>
                        <td>{{ $ticket->created_at->format('d/m/Y h:i a') }}</td>
                        <td>{{ $ticket->due_date? $ticket->due_date->format('d/m/Y h:i a') : 'Not Assigned' }}</td>
                        <td>{{ $ticket->status->name }}</td>
                        <td>{{ $ticket->category->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $tickets])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No tickets found</strong></div>
    @endif
@stop
