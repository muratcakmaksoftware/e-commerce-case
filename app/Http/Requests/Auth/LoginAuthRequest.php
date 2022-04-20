<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class LoginAuthRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string',
        ];
    }
}
