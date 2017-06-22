<?php

namespace App\Http\Requests;

class ApprovalRequest extends Request
{
    public function authorize()
    {
        $ticket = $this->route()->parameter('ticket');
        return can('send_approval', $ticket);
//        return true;
    }

    public function rules()
    {
        return [
            'approver_id' => 'required', 'content' => 'required'
        ];
    }

    public function response(array $errors)
    {
        flash('Cannot send approval');

        return \Redirect::back()->withErrors($errors)->withInput($this->all());
    }

    public function forbiddenResponse()
    {
        flash('You cannot add approval for this ticket');

        return \Redirect::back();
    }
}
