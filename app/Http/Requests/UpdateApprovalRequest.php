<?php

namespace App\Http\Requests;


use App\TicketApproval;

class UpdateApprovalRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required',
            'comment' => 'requiredIf:status,'.TicketApproval::DENIED
        ];
    }

    public function messages()
    {
        return [
            'comment.required_if' => 'Please specify deny reason'
        ];
    }
}
