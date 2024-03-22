<?php

namespace App\Services;

use App\Exceptions\AuthException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * @param $data
     * @return bool|string
     * @throws AuthException
     */
    public function loginByEmail($data): bool|string
    {
        return $this->getToken($data);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $user = Auth::user();
        $userToken = $user->token();
        $userToken->revoke();
    }

    /**
     * @param $data
     * @return bool
     * @throws AuthException
     */
    private function checkCredentials($data): bool
    {
        if (!Auth::attempt($data)) {
            throw new AuthException('You cannot sign with those credentials');
        }

        return true;
    }

    /**
     * @param $data
     * @return bool|string
     * @throws AuthException
     */
    private function getToken($data): bool|string
    {
        if ($this->checkCredentials($data)) {
            $token = Auth::user()->createToken(config('app.name'));
            return $token->accessToken;
        }

        return false;
    }

    /**
     * @return array
     */
    public function userData(): array
    {
        $user = auth()->user();
        $userData = [
            'username' => $user->username,
            'email' => $user->email,
        ];

        return $userData;
    }
}
