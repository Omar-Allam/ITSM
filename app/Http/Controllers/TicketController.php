<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Jobs\ApplySLA;
use App\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::paginate();

        return view('ticket.index', compact('tickets'));
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(TicketRequest $request)
    {
        $ticket = new Ticket($request->all());

        $ticket->creator_id = $request->user()->id;
        $ticket->requester_id = $request->user()->id;
        $ticket->location_id = $request->user()->location_id;
        $ticket->business_unit_id = $request->user()->business_unit_id;
        $ticket->status_id = 1;

        $ticket->save();

        $this->dispatch(new ApplySLA($ticket));

        flash('Ticket has been saved', 'success');

        return \Redirect::route('ticket.index');
    }

    public function show(Ticket $ticket)
    {
        return view('ticket.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', compact('ticket'));
    }

    public function update(Ticket $ticket, TicketRequest $request)
    {
        $ticket->update($request->all());

        $this->dispatch(new ApplySLA($ticket));

        flash('Ticket has been saved', 'success');

        return \Redirect::route('ticket.index');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        flash('Ticket has been deleted', 'success');

        return \Redirect::route('ticket.index');
    }
}
