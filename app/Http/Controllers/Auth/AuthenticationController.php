<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Auth\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function __construct(private AuthenticationService $service)
    {}

    public function register(RegisterUserRequest $request)
    {
        $this->service->register($request->validated());

        return response()->json([
            'message' => 'Usuário registrado com sucesso, por favor, realize o login.'
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $tokenResponse = $this->service->login($request->validated());
        return response()->json($tokenResponse);
    }

    public function logout()
    {
        $this->service->logout();

        return response()->json([
            'message' => 'Deslogado com sucesso!'
        ]);
    }
}
