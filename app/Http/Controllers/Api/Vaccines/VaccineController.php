<?php

namespace App\Http\Controllers\Api\Vaccines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
// use App\Http\Requests\Api\Vaccines;
use App\Http\Requests\Api\Vaccine\VaccineRequest;
use Exception;

class VaccineController extends Controller
{

    public function store(VaccineRequest $request)
    {
        try {

            $data = $request->validated();
            // pega do VaccineRequest

            // 2️ Associa o usuário autenticado
            $data['user_id'] = Auth::id();

            // 3️ Cria o registro já com o relacionamento
            $vaccine = Vaccine::create($data);


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


    public function index(Request $request)
    {
        try {

            $user = Auth::user();
            // vai pegar o usuario autentificado

            $query = Vaccine::where('user_id', $user->id);
            // vai buscar pelo o user_id

            if ($request->boolean('nopage')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lista de Vacinas paginadas buscada com sucesso!!',
                    'data' => $query->ordenBy('id')->get()
                ], 200);
            }

            $perPage = request()->get('per_page', 10);
            $vaccinePage = Vaccine::where('user_id', $user->id)->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $vaccinePage->items(),
                'meta' => [
                    'current_page' => $vaccinePage->currentPage(),
                    'last_page' => $vaccinePage->lastPage(),
                    'per_page' => $vaccinePage->perPage(),
                    'total' => $vaccinePage->total(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
