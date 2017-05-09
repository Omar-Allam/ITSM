<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TimeSpentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function ticket_opened_today()
    {
        $minutes = 120;
        $created_at = \Carbon\Carbon::now()->subMinutes($minutes);

        $ticket = $this->makeTicket();
        $ticket->created_at = $created_at;
        $ticket->sla_id = $this->sla()->id;
        $ticket->status_id = 1;
        $ticket->save();

        // Stop logs because it needs authenticated user
        $ticket->stopLog(true);

        $ticket->touch();

        $this->assertEquals($minutes, $ticket->fresh()->time_spent);
    }

    /** @test */
    public function weekends_not_calculated()
    {
        $minutes = 5 * 1440;
        $created_at = \Carbon\Carbon::now()->subDays(7);

        $ticket = $this->makeTicket();
        $ticket->created_at = $created_at;
        $ticket->sla_id = $this->sla()->id;
        $ticket->status_id = 1;
        $ticket->save();

        // Stop logs because it needs authenticated user
        $ticket->stopLog(true);

        $ticket->touch();

        $this->assertEquals($minutes, $ticket->fresh()->time_spent);
    }

    /** @test */
    public function ticket_has_logs()
    {
        $created_at = \Carbon\Carbon::now()->subDays(7);

        $ticket = $this->makeTicket();
        $ticket->created_at = $created_at;
        $ticket->sla_id = $this->sla(true)->id;
        $ticket->status_id = 1;
        $ticket->save();

        // Stop logs because it needs authenticated user
        $ticket->stopLog(true);

        \Auth::loginUsingId(1);

        $ticket->status_id = 5;
        $log = \App\TicketLog::addUpdating($ticket);
        $created_at->addDay();
        $log->created_at = $created_at;
        $log->save();

        $ticket->status_id = 3;
        $log = \App\TicketLog::addUpdating($ticket);
        $created_at->addDay();
        $log->created_at = $created_at;
        $log->save();

        $ticket->status_id = 5;
        $log = \App\TicketLog::addUpdating($ticket);
        $created_at->addDay();
        $log->created_at = $created_at;
        $log->save();

        $ticket->status_id = 4;
        $log = \App\TicketLog::addUpdating($ticket);
        $created_at->addDay();
        $log->created_at = $created_at;
        $log->save();

        $ticket->status_id = 3;
        $log = \App\TicketLog::addUpdating($ticket);
        $created_at->addDay();
        $log->created_at = $created_at;
        $log->save();


        $ticket->status_id = 7;
        $log = \App\TicketLog::addUpdating($ticket);
        $created_at->addDay();
        $log->created_at = $created_at;
        $log->save();

        dispatch(new \App\Jobs\CalculateTicketTime($ticket));
        \Auth::logout();
        
        $this->assertEquals(3 * 1440, $ticket->fresh()->time_spent);
    }

    /**
     * @return \App\Ticket
     */
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
//    $ticket->save();

        return $ticket;
    }

    protected function user()
    {
        return \App\User::first();
    }

    private function sla($critical = false)
    {
        $sla = \App\Sla::create([
            'name' => 'Test SLA',
            'description' => 'Test SLA',
            'due_days' => 1,
            'due_hours' => 0,
            'due_minutes' => 0,
            'response_days' => 0,
            'response_hours' => 4,
            'response_minutes' => 0,
            'critical' => $critical
        ]);

        return $sla;
    }
}
