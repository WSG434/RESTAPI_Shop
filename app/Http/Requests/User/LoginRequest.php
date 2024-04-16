<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password'=> ['required']
        ];
    }
}
