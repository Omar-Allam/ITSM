<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    protected $rules = ['name' => 'required'];

    public function index()
    {
        $tickets = Ticket::paginate();

        return view('ticket.index', compact('tickets'));
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(Request $request)
    {
        $this->validates($request, 'Could not save ticket');

        Ticket::create($request->all());

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

    public function update(Ticket $ticket, Request $request)
    {
        $this->validates($request, 'Could not save ticket');

        $ticket->update($request->all());

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
