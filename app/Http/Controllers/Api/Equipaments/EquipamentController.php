<?php

namespace App\Http\Controllers\Api\Equipaments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipament;
use App\Http\Requests\Api\Equipament\EquipamentRequest;

class EquipamentController extends Controller
{
    public function __construct(
        protected Equipament $equipament
    ) {}


    public function index(Request $request)
    {
        $equipament = Equipament::all();

        return response()->json([
            'message' => 'Equipamentos recuperados com sucesso.',
            'equipaments' => $equipament,
        ], 200);
    }


    public function store(EquipamentRequest $request)
    {
        $equipament = Equipament::create($request->validated());

        return response()->json([
            'message' => 'Equipamento criado com sucesso.',
            'equipament' => $equipament,
        ], 201);
    }


    public function show($id)
    {
        $equipament = Equipament::find($id);

        if (!$equipament) {
            return response()->json([
                'message' => 'Equipamento não encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Equipamento recuperado com sucesso.',
            'equipament' => $equipament,
        ], 200);
    }

    public function update(EquipamentRequest $request, $id)
    {
        $equipament = Equipament::find($id);

        if (!$equipament) {
            return response()->json([
                'message' => 'Equipamento não encontrado.',
            ], 404);
        }

        $equipament->update($request->validated());

        return response()->json([
            'message' => 'Equipamento atualizado com sucesso.',
            'equipament' => $equipament,
        ], 200);
    }
}
