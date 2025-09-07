<?php

namespace App\Http\Controllers\Api\Vaccines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Support\Facades\Log;
use Exception;

class VaccineController extends Controller
{
    
    public function store(Request $request) 
    {
        try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age_range' => 'required|string|max:255',
            'status' => 'required|string|max:100',
            'application_date' => 'required|string|max:100',
        ]);

        $vaccine = Vaccine::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Vacina cadastrado com sucesso.',
            'data' => $vaccine
        ], 201);

    } catch (Exception $e) {
        Log::error('Erro ao cadastrar vacina: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar a vacina.',
            'error' => $e->getMessage()
        ], 500);
    }
    }


    public function getAllVaccines()
    {
        try {
            $vaccine = Vaccine::all();

            return response()->json([
                'success' => true,
                'message' => 'Lista de vacinas restaurada com sucesso.',
                'data' => $vaccine
            ], 200);

        } catch (Exception $e) {
            Log::error('Erro ao buscar as vacinas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao buscar as vacinas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     public function update(Request $request, $id)
    {
        try {
            $vaccine = Vaccine::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'age_range' => 'required|string|max:255',
                'status' => 'required|string|max:100',
                'application_date' => 'required|string|max:100',
            ]);

            $vaccine->update($validated);

            return response()->json(['message' => 'Vacina editada com sucesso.', 'vaccine' => $vaccine], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao editar vacina.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vaccine = Vaccine::findOrFail($id);
            $vaccine->delete();

            return response()->json(['message' => 'Vacina excluída com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir a vacina.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function count()
    {
        $vaccine = Vaccine::withTrashed()->count();
        return response()->json([
            'total' => $vaccine,
            'data' => $vaccine,
            'message' => 'Quantidade de vacinas atualizada com sucesso',
        ], 200);
    }

    public function forceDelete($id)
        {
            try {
                $vaccine = Vaccine::withTrashed()->findOrFail($id);
                $vaccine->forceDelete();

            return response()->json([
            'message' => 'Vacina excluída permanentemente.'
            ], 200);
            } catch (Exception $e) {
        return response()->json([
            'message' => 'Erro ao excluir permanentemente.',
            'error' => $e->getMessage()
        ], 500);
            }
        }
}
