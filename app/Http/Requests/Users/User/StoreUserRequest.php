<?php

namespace App\Http\Requests\Users\User;

use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ];
    }
}
