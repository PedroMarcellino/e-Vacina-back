<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getAll()
    {
        try {
            $users = User::withTrashed()->get();
            return response()->json(['data' => $users], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao buscar usuários.', 'error' => $e->getMessage()], 500);
        }
    }

    public function resetPassword($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->password = Hash::make('lta@123');
            $user->save();

            return response()->json(['message' => 'Senha redefinida para lta@123 com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao redefinir senha.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $validated['password'] = Hash::make('lta@123');

            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('avatars', 'local');
                $validated['avatar_path'] = $path;
            }

            $user = User::create($validated);

            return response()->json(['message' => 'Usuário criado com sucesso.', 'user' => $user], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao criar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function enable($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();

            return response()->json(['message' => 'Usuário habilitado com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao habilitar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function disable($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return response()->json(['message' => 'Usuário desabilitado com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao desabilitar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'remove_avatar' => 'nullable|boolean',
            ]);

            if ($request->hasFile('avatar')) {
                if ($user->avatar_path && Storage::disk('local')->exists($user->avatar_path)) {
                    Storage::disk('local')->delete($user->avatar_path);
                }
                $path = $request->file('avatar')->store('avatars', 'local');
                $validated['avatar_path'] = $path;
            } elseif ($request->input('remove_avatar')) {
                if ($user->avatar_path && Storage::disk('local')->exists($user->avatar_path)) {
                    Storage::disk('local')->delete($user->avatar_path);
                }
                $validated['avatar_path'] = null;
            }

            $user->update($validated);

            return response()->json(['message' => 'Usuário editado com sucesso.', 'user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao editar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            if ($user->avatar_path && Storage::exists($user->avatar_path)) {
                Storage::delete($user->avatar_path);
            }
            $user->forceDelete();

            return response()->json(['message' => 'Usuário excluído com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao excluir usuário.', 'error' => $e->getMessage()], 500);
        }
    }
}
