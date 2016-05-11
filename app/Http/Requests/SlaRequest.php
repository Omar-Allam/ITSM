<?php

namespace App\Http\Requests;

/**
 * @property mixed criterions
 */
class SlaRequest extends Request
{
    public function rules()
    {
        $this->defineRules();

        return [
            'name' => 'required',
            'due_days' => 'filled|has_time',
            'criterions.*.field' => 'required',
            'criterions.*.operator' => 'required',
            'criterions.*.value' => 'required',
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

        foreach ($errors as $key => $value) {
            if (strstr($key, 'criterions')) {
                $errors['criteria'] = 'Invalid criteria';
                break;
            }
        }

        return \Redirect::back()->withErrors($errors)->withInput($this->all());
    }

    public function authorize()
    {
        return true;
    }
}
