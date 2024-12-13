<?php

namespace App\Http\Controllers\Api;

use App\Models\PasoReceta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class paso_receta_controller extends Controller
{
    /**
     * Display a listing of the steps for a specific recipe.
     */
    public function index($id_receta)
    {
        // Devuelve todos los pasos de la receta especificada por id_receta
        $pasosReceta = PasoReceta::where('id_recetas', $id_receta)->get();

        if ($pasosReceta->isEmpty()) {
            return response()->json(['message' => 'No se encontraron pasos para esta receta.'], 404);
        }

        return response()->json(['pasos' => $pasosReceta], 200); // Responde con los pasos de la receta
    }

    /**
     * Store a newly created step in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_recetas' => 'required|exists:recetas,id_recetas', // Validación de existencia de receta
            'paso_numero' => 'required|integer|unique:pasos_receta,paso_numero,NULL,id_recetas,id_recetas,' . $request->id_recetas, // Unicidad por receta
            'descripcion' => 'required|string', // Validación de descripción
        ]);

        // Crear el nuevo paso
        $pasoReceta = PasoReceta::create([
            'id_recetas' => $request->id_recetas,
            'paso_numero' => $request->paso_numero,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($pasoReceta, 201); // Responde con el paso creado
    }

    /**
     * Display the specified step.
     */
    public function show($id)
    {
        // Encuentra el paso o lanza un error 404 automáticamente
        $pasoReceta = PasoReceta::findOrFail($id);

        return response()->json($pasoReceta, 200); // Devuelve el paso encontrado
    }

    /**
     * Update the specified step in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'paso_numero' => 'required|integer|unique:pasos_receta,paso_numero,NULL,id_recetas,id_recetas,' . $request->id_recetas, // Unicidad por receta
            'descripcion' => 'required|string', // Validación de descripción
        ]);

        // Encuentra el paso o lanza error 404
        $pasoReceta = PasoReceta::findOrFail($id);

        // Actualiza el paso
        $pasoReceta->update([
            'paso_numero' => $request->paso_numero,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($pasoReceta, 200); // Devuelve el paso actualizado
    }

    /**
     * Remove the specified step from storage.
     */
    public function destroy($id)
    {
        // Encuentra el paso o lanza error 404
        $pasoReceta = PasoReceta::findOrFail($id);

        // Elimina el paso
        $pasoReceta->delete();

        return response()->json(['message' => 'Step deleted successfully'], 200); // Responde con mensaje de éxito
    }
}
