<?php

namespace App\Http\Controllers;

use App\Helpers\Ticket\TicketViewScope;
use App\Http\Requests\ApprovalRequest;
use App\Http\Requests\NoteRequest;
use App\Http\Requests\ReassignRequest;
use App\Http\Requests\TicketReplyRequest;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketResolveRequest;
use App\Jobs\ApplySLA;
use App\Jobs\NewNoteJob;
use App\Jobs\NewTicketJob;
use App\Jobs\SendApproval;
use App\Jobs\TicketAssigned;
use App\Jobs\TicketReplyJob;
use App\Mail\EscalationMail;
use App\Ticket;
use App\TicketApproval;
use App\TicketNote;
use App\TicketReply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class TicketController extends Controller
{
    public function index()
    {

        $scope = \Session::get('ticket.scope', 'my_pending');
        if (\Session::has('ticket.filter')) {
            $query = Ticket::scopedView('in_my_groups')->filter(session('ticket.filter'));
        } else {
            $query = Ticket::scopedView($scope);
        }

        $tickets = $query->latest('id')->paginate();

        $scopes = TicketViewScope::getScopes();
        return view('ticket.index', compact('tickets', 'scopes', 'scope'));
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(TicketRequest $request)
    {
        $ticket = new Ticket($request->all());

        $ticket->creator_id = $request->user()->id;
        if (!$request->get('requester_id')) {
            $ticket->requester_id = $request->user()->id;
        }
        $ticket->location_id = $ticket->requester->location_id;
        $ticket->business_unit_id = $ticket->requester->business_unit_id;
        $ticket->status_id = 1;

        // Fires created event in \App\Providers\TicketEventsProvider
        $ticket->save();
        $ticket->syncFields($request->get('cf', []));

        $this->dispatch(new NewTicketJob($ticket));

        flash(t('Ticket has been saved'), 'success');

        return \Redirect::route('ticket.show', $ticket);
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
//        $ticket->update($request->all());
//
//        flash('Ticket has been saved', 'success');

        return \Redirect::route('ticket.index');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        flash(t('Ticket has been deleted'), 'success');

        return \Redirect::route('ticket.index');
    }

    public function reply(Ticket $ticket, TicketReplyRequest $request)
    {
        $reply = new TicketReply($request->get('reply'));
        $reply->user_id = $request->user()->id;

        // Fires creating event in \App\Providers\TicketReplyEventProvider
        $ticket->replies()->save($reply);

        //@todo: Calculate elapsed time
        return $this->backSuccessResponse($request, 'Reply has been added');
    }

    public function resolution(Ticket $ticket, TicketResolveRequest $request)
    {
        $data = ['content' => $request->get('content'), 'status_id' => 7, 'user_id' => $request->user()->id];
        // Fires creating event in \App\Providers\TicketReplyEventProvider
        $reply = $ticket->replies()->create($data);

        //@todo: Calculate elapsed time
        $this->dispatch(new TicketReplyJob($reply));

        return $this->backSuccessResponse($request, 'Ticket has been resolved');
    }

    public function jump(Request $request)
    {
        $ticket = Ticket::find(intval($request->id));
        if (!$ticket) {
            $ticket = Ticket::where('sdp_id', $request->id)->first();
            if ($ticket) {
                return \Redirect::route('ticket.show', $ticket->id);
            }
        }
        if ($ticket) {
            return \Redirect::route('ticket.show', $request->id);
        }

        flash(t('Ticket not found'));
        return \Redirect::route('ticket.index');
    }

    public function reassign(Ticket $ticket, ReassignRequest $request)
    {
        $ticket->update($request->only(['group_id', 'technician_id', 'category_id', 'subcategory_id', 'item_id']));

        $this->dispatch(new TicketAssigned($ticket));

        flash('Ticket has been re-assigned', 'success');
        return \Redirect::route('ticket.show', $ticket);
    }

    public function scope(Request $request)
    {
        \Session::put('ticket.scope', $request->get('scope')); // as set function deprecated by laravel
        return \Redirect::route('ticket.index');
    }

    public function duplicate(Ticket $ticket, Request $request)
    {
        $data = $ticket->toArray();

        unset($data['id'], $data['created_at'], $data['updated_at']);

        $newTicket = new Ticket($data);
        $newTicket->creator_id = $request->user()->id;
        $newTicket->status_id = 1;

        $newTicket->save();

        $this->dispatch(new NewTicketJob($newTicket));

        return \Redirect::route('ticket.show', $newTicket);
    }

    public function filter(Request $request)
    {
        session(['ticket.filter' => $request->get('criterions')]);

        return \Redirect::back();
    }

    public function clear()
    {
        \Session::remove('ticket.filter');

        return \Redirect::back();
    }

    public function addNote(Ticket $ticket, NoteRequest $request)
    {
        $note = TicketNote::create(['ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'note' => $request->get('note'),
            'display_to_requester' => $request->display_to_requester ? 1 : 0,
            'email_to_technician' => $request->email_to_technician ? 1 : 0,
            'as_first_response' => $request->as_first_response ? 1 : 0
        ]);
        if ($note->email_to_technician) {
            $this->dispatch(new NewNoteJob($note));
        }
        if ($note->as_first_response) {
            $this->dispatch(new ApplySLA($note->ticket));
        }
        flash('Your note has been created', 'success');
        return \Redirect::route('ticket.show', $note->ticket);
    }

    public function editResolution(Ticket $ticket, TicketResolveRequest $request)
    {
        $ticket->replies()->where('status_id', 7)
            ->update(['content' => $request->get('content')]);
        flash('Resolution saved successfully', 'success');
        return \Redirect::back();
    }


    public function editNote($note, Request $request)
    {
        $note = TicketNote::find($note);
        $validate = \Validator::make($request->all(), [
            'note' => 'required',
        ]);
        if($validate->fails()){
            flash('Your note has not been updated', 'danger');
            return \Redirect::route('ticket.show', $note->ticket);
        }
        $note->note = $request->note;
        $note->display_to_requester = $request->display_to_requester ? 1 : 0;
        $note->email_to_technician = $request->email_to_technician ? 1 : 0;
        $note->as_first_response = $request->as_first_response ? 1 : 0;
        $note->save();

        if ($note->email_to_technician) {
            $this->dispatch(new NewNoteJob($note));
        }
        flash('Your note has been updated', 'success');
        return \Redirect::route('ticket.show', $note->ticket);
    }

    public function deleteNote($note)
    {
        $target_note = TicketNote::find($note);
        $ticket = $target_note->ticket;
        $target_note->delete();
        flash('Your note has been deleted', 'success');
        return \Redirect::route('ticket.show', $ticket);
    }
}
