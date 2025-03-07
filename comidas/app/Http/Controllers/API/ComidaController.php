<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comida;
use Illuminate\Http\Request;

class ComidaController extends Controller
{
    /**
     * Muestra la lista de comidas.
     */
    public function index()
    {
        $comidas = Comida::all();
        return response()->json($comidas);
    }

    /**
     * Almacena una nueva comida.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo'   => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $comida = Comida::create($validated);
        return response()->json($comida, 201);
    }

    /**
     * Muestra una comida en específico.
     */
    public function show(Comida $comida)
    {
        return response()->json($comida);
    }

    /**
     * Actualiza una comida existente.
     */
    public function update(Request $request, Comida $comida)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo'   => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $comida->update($validated);
        return response()->json($comida);
    }

    /**
     * Elimina una comida.
     */
    public function destroy(Comida $comida)
    {
        $comida->delete();
        return response()->json(null, 204);
    }
}
