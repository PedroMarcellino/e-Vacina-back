<?php

namespace App\Http\Controllers\Api\Vaccines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
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

            $vaccine = Vaccine::create([
                'name' => $request->name,
                'age_range' => $request->age_range,
                'status' => $request->status,
                'application_date' => $request->application_date,
                'user_id' => Auth::id(),
            ]);

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

            $user = Auth::user();
            return Vaccine::where('user_id', $user->id)->get();

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
            $vaccine->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Vacina excluída definitivamente.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir a vacina.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function count()
    {
        try {
            $userId = Auth::id(); // pega usuário autenticado

            $vaccineCount = Vaccine::withTrashed()
                ->where('user_id', $userId) // filtra pelo usuário
                ->count();

            return response()->json([
                'success' => true,
                'total'   => $vaccineCount,
                'data'    => $vaccineCount,
                'message' => 'Quantidade de vacinas atualizada com sucesso',
            ], 200);
        } catch (Exception $e) {
            Log::error('Erro ao contar vacinas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao contar vacinas.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function forceDelete($id)
    {
        try {
            $vaccine = Vaccine::withTrashed()->findOrFail($id);

            $vaccine->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Vacina excluída permanentemente.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir permanentemente.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function lastVaccine()
    {
        try {
            $userId = Auth::id(); // pega usuário autenticado

            $vaccine = Vaccine::where('user_id', $userId) // filtra pelo usuário
                ->orderBy('application_date', 'desc')
                ->first();

            if (!$vaccine) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nenhuma vacina encontrada.',
                    'data'    => null
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Última vacina encontrada com sucesso.',
                'data'    => $vaccine
            ], 200);
        } catch (Exception $e) {
            Log::error('Erro ao buscar última vacina: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar última vacina.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function generatePdf()
    {
        try {
            $user = Auth::user();

            $vaccines = Vaccine::where('user_id', $user->id)->get();
            $vaccineCount = Vaccine::where('user_id', $user->id)->count();

            $pdf = Pdf::loadView('reports.vaccines', [
                'user' => $user,
                'vaccines' => $vaccines,
                'vaccineCount' => $vaccineCount 
            ]);

            return $pdf->download('relatorio_vacinas.pdf');
        } catch (Exception $e) {

            Log::error('Erro ao gerar PDF: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar relatório em PDF.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
