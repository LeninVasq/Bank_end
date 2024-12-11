<?php

namespace App\Http\Controllers\Api;

use App\Models\PasoReceta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  


class paso_receta_controller extends Controller
{
    /**
     * Display a listing of the steps.
     */
    public function index()
    {
        // Devuelve todos los pasos de receta sin paginación
        return PasoReceta::all();
    }

    /**
     * Store a newly created step in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_recetas' => 'required|exists:recetas,id_recetas',
            'paso_numero' => 'required|integer|unique:pasos_receta,paso_numero,NULL,id_recetas,id_recetas,' . $request->id_recetas, // Validación de unicidad por receta
            'descripcion' => 'required|string',
        ]);

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

        return response()->json($pasoReceta); // Devuelve el paso encontrado
    }

    /**
     * Update the specified step in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'paso_numero' => 'required|integer|unique:pasos_receta,paso_numero,NULL,id_recetas,id_recetas,' . $request->id_recetas, // Validación de unicidad por receta
            'descripcion' => 'required|string',
        ]);

        $pasoReceta = PasoReceta::findOrFail($id); // Encuentra el paso o lanza error 404

        $pasoReceta->update([
            'paso_numero' => $request->paso_numero,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($pasoReceta); // Devuelve el paso actualizado
    }

    /**
     * Remove the specified step from storage.
     */
    public function destroy($id)
    {
        $pasoReceta = PasoReceta::findOrFail($id); // Encuentra el paso o lanza error 404

        $pasoReceta->delete(); // Elimina el paso de la receta

        return response()->json(['message' => 'Step deleted successfully']); // Responde con mensaje de éxito
    }
}
