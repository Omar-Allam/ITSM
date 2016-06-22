<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class TicketLogsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function reply_log()
    {
        $ticket = $this->makeTicket();

        $ticket->replies()->create(['user_id' => \Auth::user()->id, 'content' => 'Test replies', 'status_id' => 3]);

        $this->seeInDatabase('ticket_logs', ['ticket_id' => $ticket->id, 'type' => \App\TicketLog::REPLY_TYPE]);
    }

    /** @test */
    public function approval_log()
    {
        $ticket = $this->makeTicket();

        $this->makeApproval($ticket);

        $this->seeInDatabase('ticket_logs', ['ticket_id' => $ticket->id, 'type' => \App\TicketLog::APPROVAL_TYPE]);
    }

    /** @test */
    public function approved_log()
    {
        $ticket = $this->makeTicket();
        $approval = $this->makeApproval($ticket);

        $approval->approval_date = \Carbon\Carbon::now();
        $approval->status = \App\TicketApproval::APPROVED;
        $approval->save();

        $this->seeInDatabase('ticket_logs', ['ticket_id' => $ticket->id, 'type' => \App\TicketLog::APPROVED]);
    }

    /** @test */
    public function denied_log()
    {
        $ticket = $this->makeTicket();
        $approval = $this->makeApproval($ticket);

        $approval->approval_date = \Carbon\Carbon::now();
        $approval->status = \App\TicketApproval::DENIED;
        $approval->save();

        $this->seeInDatabase('ticket_logs', ['ticket_id' => $ticket->id, 'type' => \App\TicketLog::DENIED]);
    }

    protected function makeTicket()
    {
        $user = \App\User::orderByRaw('RAND()')->first();

        $category = \App\Category::find(1);
        $subcategory = $category->subcategories()->first();

        $ticket = new \App\Ticket([
            'subject' => 'Test Ticket',
            'description' => 'Test description',
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'priority_id' => 1,
            'urgency_id' => 1
        ]);

        $ticket->requester_id = $user->id;
        $ticket->creator_id = $user->id;
        $ticket->save();

        return $ticket;
    }

    /**
     * @param \App\Ticket $ticket
     *
     * @return \App\TicketApproval
     */
    protected function makeApproval(\App\Ticket $ticket)
    {
        $approval = new \App\TicketApproval(['approver_id' => 1, 'content' => 'Test replies']);
        $approval->creator_id = \Auth::user()->id;
        return $ticket->approvals()->save($approval);
    }
}
