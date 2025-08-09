<?php
namespace App\Service\Auth;

use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;
use Throwable;

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials): ?array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('auth_token')->accessToken;


        Log::info('User logged in', [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'timestamp' => now(),
        ]);
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function register(array $data): array
    {
        $data['type'] = $data['type'] ?? 'client';
        $data['password'] = Hash::make($data['password']);

        try {
            DB::beginTransaction();

            $user = $this->userRepository->create($data);

            // Espaço disponível para adicionar envio de email

            DB::commit();

            return $user->toArray();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado.'], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }
}
