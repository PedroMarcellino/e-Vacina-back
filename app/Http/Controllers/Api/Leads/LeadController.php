<?php

namespace App\Http\Controllers\Api\Leads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Leads\CreateLeadRequest;
use Illuminate\Http\Request;
use Exception;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function __construct(
        protected Lead $lead
    ) {}

    public function store(CreateLeadRequest $request)
    {
        $lead = Lead::create($request->validated());

        return response()->json([
            'message' => 'Mensagem enviada com sucesso. Em breve entraremos em contato.',
            'lead' => $lead,
        ], 201);
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Lead::where('user_id', $user->id);

        $query = $this->lead->newQuery();

        if ($request->has('full_name')) {
            $query->where('full_name', 'like', '%' . $request->query('full_name') . '%');
        }

        if ($request->boolean('nopage')) {
            return response()->json([
                'success' => true,
                'messange' => 'Lista de Lead recuperada com sucesso!',
                'data' => $query->ordenBy('id')->get()
            ], 200);
        }

        $perPage = request()->get('per_page', 10);
        $leadPage = Lead::where('user_id', $user->id)->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $leadPage->items(),
            'meta' => [
                'current_page' => $leadPage->currentPage(),
                'last_page' => $leadPage->lastPage(),
                'per_page' => $leadPage->perPage(),
                'total' => $leadPage->total(),
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:leads,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string|max:600'
            ]);

            $lead->update($validated);

            return response()->json(['message' => 'Usuário editado com sucesso.', 'user' => $lead], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao editar usuário.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $lead->delete();

            return response()->json(['message' => 'Lead excluído com sucesso.'], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir o lead.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function count()
    {
        $lead = Lead::withTrashed()->count();
        return response()->json([
            'total' => $lead,
            'data' => $lead,
            'message' => 'Quantidade de leads atualizada com sucesso',
        ], 200);
    }

    public function forceDelete($id)
    {
        try {
            $lead = Lead::withTrashed()->findOrFail($id);
            $lead->forceDelete();

            return response()->json([
                'message' => 'Lead excluído permanentemente.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir permanentemente.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
