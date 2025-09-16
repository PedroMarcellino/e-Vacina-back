<?php

namespace App\Http\Controllers\Api\Families;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Family;

class FamilyController extends Controller {

    public function store(Request $request) 
    {
        try {
        $validated = $request->validate([
           // 'name' => 'required|string|max:255',
            'relative_name' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'status' => 'required|string|max:100',
            'name_vaccine' => 'required|string|max:255',
            'application_date' => 'required|string|max:100',
        ]);

        $family = Family::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Familiar cadastrado com sucesso.',
            'data' => $family
        ], 201);

    } catch (Exception $e) {
        Log::error('Erro ao cadastrar o familiar: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar o familiar.',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    
    public function getAllFamily()
    {
        try {
            $family = Family::all();

            return response()->json([
                'success' => true,
                'message' => 'Lista de familiares restaurada com sucesso.',
                'data' => $family
            ], 200);

        } catch (Exception $e) {
            Log::error('Erro ao buscar os familiares: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao buscar os familiares.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $family = Family::findOrFail($id);

            $validated = $request->validate([
            //    'name' => 'required|string|max:255',
                'relative_name' => 'required|string|max:255',
                'age' => 'required|string|max:255',
                'status' => 'required|string|max:100',
                'name_vaccine' => 'required|string|max:255',
                'application_date' => 'required|string|max:100',
            ]);

            $family->update($validated);

            return response()->json(['message' => 'Familiar editado com sucesso.', 'family' => $family], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao editar o familiar.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $family = Family::findOrFail($id);
            $family->delete(); 

            return response()->json(['message' => 'Familiar excluído com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir o familiar.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function count()
    {
        $family = Family::withTrashed()->count();
        return response()->json([
            'total' => $family,
            'data' => $family,
            'message' => 'Quantidade de familiares atualizado com sucesso',
        ], 200);
    }

    public function forceDelete($id)
        {
            try {
                $family = Family::withTrashed()->findOrFail($id);
                $family->forceDelete();

            return response()->json([
            'message' => 'Familiar excluído permanentemente.'
            ], 200);
            } catch (Exception $e) {
        return response()->json([
            'message' => 'Erro ao excluir permanentemente.',
            'error' => $e->getMessage()
        ], 500);
            }
        }
}