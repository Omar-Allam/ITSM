<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use App\Jobs\SendApproval;
use App\Jobs\UpdateApprovalJob;
use App\Ticket;
use App\TicketApproval;
use App\TicketLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;

class ApprovalController extends Controller
{
    public function send(Ticket $ticket, ApprovalRequest $request)
    {
        //Triggers created action in App\Providers\TicketEventsProvider
        $approval = new TicketApproval($request->all());
        $approval->creator_id = $request->user()->id;
        $approval->status = 0;
        if ($request->get('add_stage')) {
            $approval->stage = $ticket->nextApprovalStage();
        } elseif (!$ticket->hasApprovalStages()) {
            $approval->stage = 1;
        }

        $ticket->approvals()->save($approval);

        alert()->flash('Approval Info', 'success', [
            'text' => 'Approval has been sent successfully',
            'timer' => 3000
        ]);

        return $this->backSuccessResponse($request, null);
    }

    public function resend(TicketApproval $ticketApproval, Request $request)
    {
        $this->dispatch(new SendApproval($ticketApproval));
        TicketLog::resendApproval($ticketApproval);

        alert()->flash('Approval Info', 'success', [
            'text' => 'Approval has been sent successfully',
            'timer' => 3000
        ]);

        return $this->backSuccessResponse($request, null);
    }

    public function show(TicketApproval $ticketApproval, Request $request)
    {
        $result = $this->authorizeApproval($ticketApproval, $request);
        if (true !== $result) {
            return $result;
        }

        return view('approval.show', compact('ticketApproval'));
    }

    public function update(TicketApproval $ticketApproval, UpdateApprovalRequest $request)
    {
        $result = $this->authorizeApproval($ticketApproval, $request);

        if (true !== $result) {
            return $result;
        }

        //Triggers updated action in App\Providers\TicketEventsProvider
        $ticketApproval->approval_date = Carbon::now();
        $ticketApproval->update($request->all());

        if(!$ticketApproval->ticket->isClosed()){
            $ticketApproval->ticket->status_id = 3;
            $ticketApproval->ticket->save();
        }
        
        $this->dispatch(new UpdateApprovalJob($ticketApproval));

        if ($ticketApproval->status != -1 && $ticketApproval->hasNext()) {
            $approvals = $ticketApproval->getNextStageApprovals();
            foreach ($approvals as $approval) {
                $this->dispatch(new SendApproval($approval));
            }
        }

        alert()->flash('Approval Info', 'info', [
            'text' => 'Ticket has been ' . ($ticketApproval->status == TicketApproval::APPROVED ? 'approved' : 'rejected'),
            'timer' => 3000
        ]);

        return Redirect::route('ticket.show', $ticketApproval->ticket_id);
    }

    public function destroy(TicketApproval $ticketApproval, Request $request)
    {
        if ($ticketApproval->creator_id != $request->user()->id || $ticketApproval->status != TicketApproval::PENDING_APPROVAL) {

            alert()->flash('Approval Sent', 'error', [
                'text' => 'Action not authorized',
                'timer' => 3000
            ]);

            return Redirect::back();
        }

        $ticketApproval->delete();

        alert()->flash('Approval Info', 'info', [
            'text' => 'Approval has been deleted',
            'timer' => 3000
        ]);
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

            return Redirect::route('ticket.show', $ticketApproval->ticket_id);
        }

        if ($ticketApproval->status != TicketApproval::PENDING_APPROVAL) {

            alert()->flash('Approval Info', 'info', [
                'text' => 'You already took action for this approval',
                'timer' => 3000
            ]);
            return Redirect::route('ticket.show', $ticketApproval->ticket_id);
        }

        if ($ticketApproval->ticket->isClosed()) {
            alert()->flash('Approval Info', 'info', [
                'text' => 'The ticket has been closed',
                'timer' => 3000
            ]);
            return Redirect::route('ticket.show', $ticketApproval->ticket_id);
        }

        return true;
    }
}
