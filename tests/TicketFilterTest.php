<?php

use App\Helpers\Ticket\TicketFilter;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TicketFilterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function request_field_is()
    {
        $criteria = [['field' => 'category_id', 'operator' => 'is', 'value' => '2,3']];

        App\Ticket::flushEventListeners();

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'Test', 'description' => 'test'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function request_field_isnot()
    {
        $criteria = [['field' => 'category_id', 'operator' => 'isnot', 'value' => '3']];

        App\Ticket::flushEventListeners();

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'Test', 'description' => 'test'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function request_field_contains()
    {
        App\Ticket::flushEventListeners();

        $category = \App\Category::find(2);

        $tokens = explode(' ', $category->name);

        $criteria = [['field' => 'category_id', 'operator' => 'contains', 'value' => $tokens[0]]];

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => $category->id, 'subject' => 'Test', 'description' => 'test'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function request_field_contains2()
    {
        App\Ticket::flushEventListeners();

        $criteria = [['field' => 'subject', 'operator' => 'contains', 'value' => 'contains']];

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'Test contains is working', 'description' => 'test'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function request_field_does_not_contain()
    {
        App\Ticket::flushEventListeners();

        $criteria = [['field' => 'subject', 'operator' => 'notcontain', 'value' => 'contains']];

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'Cannot add the word!!', 'description' => 'Word not found in the subject'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function request_field_start()
    {
        App\Ticket::flushEventListeners();

        $criteria = [['field' => 'subject', 'operator' => 'starts', 'value' => 'start']];

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'Start should work', 'description' => 'test'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function request_field_end()
    {
        App\Ticket::flushEventListeners();

        $criteria = [['field' => 'subject', 'operator' => 'ends', 'value' => 'end']];

        $user_id = App\User::first()->id;
        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'It should work at the end', 'description' => 'test'
        ]);
        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }

    /** @test */
    public function requester_field_is()
    {
        App\Ticket::flushEventListeners();

        $user_id = App\User::orderByRaw('RAND()')->first()->id;

        $criteria = [['field' => 'requester_id', 'operator' => 'is', 'value' => $user_id]];

        $ticket = new \App\Ticket([
            'requester_id' => $user_id,
            'category_id' => 2, 'subject' => 'It should work at the end', 'description' => 'test'
        ]);

        $ticket->creator_id = $user_id;
        $ticket->save();

        $filtered = App\Ticket::filter($criteria)->latest()->first();
        $this->assertNotNull($filtered);
        $this->assertEquals($ticket->id, $filtered->id);
    }
}
