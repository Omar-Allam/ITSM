<?php

namespace App\Http\Requests;

class TicketResolveRequest extends Request
{
    public function authorize()
    {
        return can('resolve', $this->route('ticket'));
    }

    public function rules()
    {
        return [
            'content' => 'required'
        ];
    }
}
