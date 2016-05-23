<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ApprovalRequest;
use App\Jobs\SendApproval;
use App\Jobs\UpdateApprovalJob;
use App\Ticket;
use App\TicketApproval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;

class ApprovalController extends Controller
{
    public function send(Ticket $ticket, ApprovalRequest $request)
    {
        $approval = new TicketApproval($request->all());
        $approval->creator_id = $request->user()->id;
        $approval->status = 0;
        $ticket->approvals()->save($approval);

        $this->dispatch(new SendApproval($approval));

        return $this->backSuccessResponse($request, 'Approval has been sent');
    }

    public function resend(TicketApproval $ticketApproval, Request $request)
    {
        $this->dispatch(new SendApproval($ticketApproval));

        return $this->backSuccessResponse($request, 'Approval has been sent');
    }

    public function show(TicketApproval $ticketApproval, Request $request)
    {
//        $result = $this->authorizeApproval($ticketApproval, $request);
//        if (true !== $result) {
//            return $result;
//        }

        return view('approval.show', compact('ticketApproval'));
    }

    public function update(TicketApproval $ticketApproval, Request $request)
    {
//        $result = $this->authorizeApproval($ticketApproval, $request);
//        if (true !== $result) {
//            return $result;
//        }

        $ticketApproval->approval_date = Carbon::now();
        $ticketApproval->update($request->all());
        $this->dispatch(new UpdateApprovalJob());

        flash('Ticket has been ' . ($ticketApproval->status == TicketApproval::APPROVED ? 'approved' : 'rejected'), 'success');
        return Redirect::route('ticket.show', $ticketApproval->ticket_id);
    }

    public function destroy(TicketApproval $ticketApproval, Request $request)
    {
        if ($ticketApproval->creator_id != $request->user()->id && $ticketApproval->status != TicketApproval::PENDING_APPROVAL) {
            flash('Action not authorized');
            return Redirect::back();
        }

        $ticketApproval->delete();

        flash('Approval has been deleted', 'info');
        return Redirect::route('ticket.show', $ticketApproval->ticket_id);
    }

    /**
     * @param TicketApproval $ticketApproval
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function authorizeApproval(TicketApproval $ticketApproval, Request $request)
    {
        if ($ticketApproval->approver_id != $request->user()->id) {
            flash('Action not authorized');
            return Redirect::route('ticket.show', $ticketApproval->ticket_id);
        }

        if ($ticketApproval->status != TicketApproval::PENDING_APPROVAL) {
            flash('You already took action for this approval', 'info');
            return Redirect::route('ticket.show', $ticketApproval->ticket_id);
        }

        return true;
    }
}
