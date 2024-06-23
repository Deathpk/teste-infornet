<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthenticationService
{
    public function register(array $credentials): void
    {
        User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);
    }

    public function login(array $credentials): array
    {
        $token = auth()->attempt(credentials: $credentials);

        if(!$token) {
            throw new Exception('E-mail ou senha incorretos.');
        }

        return [
            'message' => 'Autenticado com sucesso!',
            'user' => Auth::user()->name,
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function logout(): void
    {
        auth()->logout();
    }
}
