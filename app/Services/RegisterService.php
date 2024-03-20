<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterService
{
    /**
     * @param $data
     * @return array
     */
    public function registerByEmail($data): array
    {
        User::create($data);

        Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $token = Auth::user()->createToken(config('app.name'));

        return [
            'user' => new UserResource(auth()->user()),
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
        ];
    }
}
