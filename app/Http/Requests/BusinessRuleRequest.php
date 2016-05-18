<?php

namespace App\Http\Requests;

class BusinessRuleRequest extends Request
{

    public function rules()
    {
        return [
            'name' => 'required',
            'criterions.*.field' => 'required',
            'criterions.*.value' => 'required',
            'rules.*.field' => 'required',
            'rules.*.value' => 'required',
        ];
    }

    public function response(array $errors)
    {
        flash('Cannot save rule');

        foreach ($errors as $key => $value) {
            if (strstr($key, 'criterions')) {
                $errors['criteria'] = 'Invalid criteria';
                break;
            }
        }

        foreach ($errors as $key => $value) {
            if (strstr($key, 'rules')) {
                $errors['rules'] = 'Invalid rules';
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
