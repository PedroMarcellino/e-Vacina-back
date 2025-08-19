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
}
