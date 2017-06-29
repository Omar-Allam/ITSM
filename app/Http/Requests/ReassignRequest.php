<?php

namespace App\Http\Requests;

use App\User;

class ReassignRequest extends Request
{
    public function authorize()
    {
        // $ticket = $this->route('ticket');

//        if (!$ticket->technician_id) {
//            return true;
//        }
//
//        return $this->user()->id == $ticket->technician_id || $this->user()->hasGroup($ticket->group_id);

        // return can('modify', $ticket);
        return true;
    }

    public function rules()
    {
        $this->defineCustomRules();

        return [
            'group_id' => 'required',
            'technician_id' => 'required|matches_group'
        ];
    }

    public function messages()
    {
        return ['matches_group' => 'Technician is not in this group'];
    }

    public function response(array $errors)
    {
        $msg = 'Cannot assign request';
        if ($this->isJson() || $this->wantsJson()) {
            return ['ok' => false, 'errors' => $errors, 'message' => $msg];
        }

        flash($msg);

        return \Redirect::route('ticket.show', $this->route('ticket'))
            ->withInput($this->all())
            ->withErrors($errors);
    }

    public function forbiddenResponse()
    {
        $msg = 'You are not authorized to do this action';

        if ($this->isJson() || $this->wantsJson()) {
            return ['ok' => false, 'errors' => ['auth' => $msg]];
        }

        flash($msg);
        return \Redirect::route('ticket.show', $this->route('ticket'));
    }

    protected function defineCustomRules()
    {
        \Validator::extend('matches_group', function() {
            $technician = User::find($this->get('technician_id'));
            return $technician->hasGroup($this->get('group_id'));
        });
    }
}
