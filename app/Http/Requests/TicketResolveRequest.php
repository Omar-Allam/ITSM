<?php

namespace App\Http\Requests;

class TicketResolveRequest extends Request
{
    public function authorize()
    {
        $ticket = $this->route()->parameter('ticket');
        return $this->user()->isTechnician() && $this->user()->hasGroup($ticket->group_id);
    }

    public function rules()
    {
        return [
            'content' => 'required'
        ];
    }
}
