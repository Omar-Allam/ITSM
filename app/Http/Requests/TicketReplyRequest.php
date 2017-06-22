<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Status;
use App\Ticket;

class TicketReplyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        $user_id = $this->user()->id;
//
        $ticket = $this->route('ticket');
//
//        return in_array($user_id, [$ticket->technician_id, $ticket->requester_id, $ticket->creator_id]);
        return can('reply', $ticket);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->addCustomRules();

        return [
            'reply.content' => 'required',
            'reply.status' => 'check_status'
        ];
    }

    public function messages()
    {
        return ['check_status' => 'Invalid status', 'required' => 'Required field'];
    }

    protected function addCustomRules()
    {
        \Validator::extend('check_status', function () {
            if ($this->status_id == 6) {
                return false;
            }

            if (!Status::where('id', $this->status_id)->exists()) {
                return false;
            }

            if (!$this->user()->isTechnician() && in_array($this->status_id, [2, 3, 5])) {

            }

            /** @var Ticket $ticket */
            $ticket = $this->route()->parameter('ticket');
            if ($this->user()->id == $ticket->technician_id && $this->status_id == 8) {
                return false;
            }

            return true;
        });
    }

    public function response(array $errors)
    {
        flash('Cannot send reply');

        return \Redirect::back()->withErrors($errors)->withInput($this->all());
    }

    public function forbiddenResponse()
    {
        flash('You cannot add reply to this ticket');

        return \Redirect::back();
    }
}
