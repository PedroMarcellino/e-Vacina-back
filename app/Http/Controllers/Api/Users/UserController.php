<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function uploadPhoto(Request $request)
{
    $request->validate([
        'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = $request->user();

    if ($request->hasFile('photo')) {
        // Apaga a antiga se existir
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Salva a nova
        $path = $request->file('photo')->store('photos', 'public');

        $user->photo = $path;
        $user->save();

        return response()->json([
            'message'   => 'Foto atualizada com sucesso!',
            'photo_url' => $user->photo_url, // 🔹 vem do accessor
            'user'      => $user,           // 🔹 retorna o user atualizado
        ]);
    }

    return response()->json(['error' => 'Nenhuma foto enviada'], 400);
}
}
