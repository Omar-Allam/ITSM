<?php

namespace App\Http\Requests;

class AdminUserRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->route()->parameter('user');

        return [
            'name' => 'required',
            'email' => 'required|email',
            'login' => 'required|unique:users,login' . ($user ? ',' . $user->id : ''),
            'password' => 'min:8|confirmed',
        ];
    }
}
