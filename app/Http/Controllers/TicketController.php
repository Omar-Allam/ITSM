<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalRequest;
use App\Http\Requests\TicketReplyRequest;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketResolveRequest;
use App\Jobs\ApplySLA;
use App\Jobs\SendApproval;
use App\Jobs\TicketReplyJob;
use App\Ticket;
use App\TicketApproval;
use App\TicketReply;
use Illuminate\Http\Request;

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

        // Fires created event in \App\Providers\TicketEventsProvider
        $ticket->save();

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
        // Fires updated event in \App\Providers\TicketEventsProvider
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

    public function reply(Ticket $ticket, TicketReplyRequest $request)
    {
        $reply = new TicketReply($request->get('reply'));
        $reply->user_id = $request->user()->id;

        // Fires creating event in \App\Providers\TicketReplyEventProvider
        $ticket->replies()->save($reply);

        $this->dispatch(new TicketReplyJob($reply));

        //@todo: Calculate elapsed time
        return $this->backResponse($request, 'Reply has been added');
    }

    public function resolution(Ticket $ticket, TicketResolveRequest $request)
    {
        $data = ['content' => $request->get('content'), 'status_id' => 7, 'user_id' => $request->user()->id];
        // Fires creating event in \App\Providers\TicketReplyEventProvider
        $reply = $ticket->replies()->create($data);

        //@todo: Calculate elapsed time
        $this->dispatch(new TicketReplyJob($reply));

        return $this->backResponse($request, 'Ticket has been resolved');
    }

    public function approval(Ticket $ticket, ApprovalRequest $request)
    {
        $approval = new TicketApproval($request->all());
        $approval->creator_id = $request->user()->id;
        $approval->status = 0;
        $ticket->approvals()->save($approval);

        $this->dispatch(new SendApproval($approval));

        return $this->backResponse($request, 'Approval has been sent');
    }

    protected function backResponse(Request $request, $msg)
    {
        if ($request->wantsJson() || $request->isJson()) {
            return ['ok' => true, 'message' => $msg];
        }

        flash($msg, 'success');

        return \Redirect::back();
    }
}
