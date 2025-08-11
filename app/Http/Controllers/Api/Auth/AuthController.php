<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Auth\AuthService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        Log::error('Login request received', ['request' => $request->all()]);

        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $credentials = $request->only('email', 'password');

            $response = $this->authService->login($credentials);

            return response()->json($response, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro no servidor.' . $e->getMessage()], 500);
        }
    }

   public function register(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->only('name', 'email', 'password');

        // Garante que a senha será criptografada
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);

        $response = $this->authService->register($data);

        return response()->json($response, 201);

    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (Exception $e) {
        // Mostra erro real no log
        \Log::error('Erro no registro', ['error' => $e->getMessage()]);
        return response()->json([
            'message' => 'Erro no servidor',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);
            return response()->json(['message' => 'Logout realizado com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao fazer logout.'], 500);
        }
    }
}
