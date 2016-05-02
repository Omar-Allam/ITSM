<?php

namespace App\Http\Requests;

class SlaRequest extends Request
{
    public function rules()
    {
        $this->defineRules();

        return [
            'name' => 'required',
            'due_days' => 'filled|has_time'
        ];
    }

    public function messages()
    {
        $dueDays = 'Due time is not defined properly';
        return ['has_time' => $dueDays, 'filled' => $dueDays];
    }

    protected function defineRules()
    {
        \Validator::extend('has_time', function () {
            $time = ($this->get('due_days', 0) * 24 * 60) + ($this->get('due_hours', 0) * 60) + $this->get('due_minutes', 0);
            return $time != 0;
        });
    }

    public function response(array $errors)
    {
        flash('Cannot save SLA');

        return \Redirect::back()->withErrors($errors)->withInput($this->all());
    }

    public function authorize()
    {
        return true;
    }
}
