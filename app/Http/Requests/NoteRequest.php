<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note' => 'required',
        ];
    }
    public function messages()
    {
        return ['text' => 'Note cannot created'];
    }
    public function response(array $errors)
    {
        $msg = 'Note Cannot Created';
        flash($msg);
        return \Redirect::route('ticket.show', $this->route('ticket'))
            ->withInput($this->all())
            ->withErrors($errors);
    }
}
