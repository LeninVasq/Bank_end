<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categoria_menu; // Aquí se hace la referencia correcta al modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class categoria_menu_controller extends Controller
{
    // Actualiza todos los campos y parcialmente
    public function update(Request $request, $id)
    {
        $categoria_menu = categoria_menu::find($id); // Se mantiene la referencia correcta al modelo
        if (!$categoria_menu) {
            return response()->json([
                'message' => 'El id de la categoria de menú no existe',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'nombre' => [
                'sometimes',
                Rule::unique('categoria_menu')->ignore($categoria_menu->id_categoria_menu, 'id_categoria_menu'),
            ],
            'descripcion' => 'sometimes|string',
            'foto' => 'sometimes|nullable',
            'estado' => 'sometimes|nullable|boolean'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'error' => $validation->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('nombre')) {
            $categoria_menu->nombre = $request->nombre; 
        }
        if ($request->has('descripcion')) {
            $categoria_menu->descripcion = $request->descripcion; 
        }
        if ($request->has('foto')) {
            $categoria_menu->foto = $request->foto; 
        }
        if ($request->has('estado')) {
            $categoria_menu->estado = $request->estado; 
        }

        $categoria_menu->save();

        return response()->json([
            'message' => 'Categoría de menú actualizada',
            'data' => $categoria_menu,
            'status' => 200
        ], 200);
    }

    // Elimina por id
    public function destroy($id)
    {
        $categoria_menu = categoria_menu::find($id);
        if (!$categoria_menu) {
            return response()->json([
                'message' => 'El id de la categoria de menú no existe',
                'status' => 404
            ], 404);
        }

        $categoria_menu->delete();

        return response()->json([
            'message' => "Se ha eliminado el registro de categoría de menú",
            'status' => 200
        ], 200);
    }

    // Consulta por id
    public function show($id)
    {
        $categoria_menu = categoria_menu::find($id);
        if (!$categoria_menu) {
            return response()->json([
                'message' => 'El id de la categoria de menú no existe',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Categoría de menú encontrada',
            'data' => $categoria_menu,
            'status' => 200
        ], 200);
    }

    // Inserción de categorías de menú
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre' => 'required|string|unique:categoria_menu',
            'descripcion' => 'required|string',
            'foto' => 'sometimes|nullable',
            'estado' => 'sometimes|nullable|boolean'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'error' => $validation->errors(),
                'status' => 400
            ], 400);
        }

        $categoria_menu = categoria_menu::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'foto' => $request->foto,
            'estado' => $request->estado
        ]);

        if (!$categoria_menu) {
            return response()->json([
                'message' => 'Error al crear la categoría de menú',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Categoría de menú creada exitosamente',
            'data' => $categoria_menu,
            'status' => 201
        ], 201);
    }

    // Lista todas las categorías de menú
    public function index()
    {
        $categorias_menu = categoria_menu::all();

        if ($categorias_menu->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorías de menú registradas',
                'status' => 200
            ], 200);
        }

        return response()->json([
            'categorias_menu' => $categorias_menu,
            'status' => 200
        ], 200);
    }

    // Lista solo las categorías de menú activas
    public function listasolo1()
    {
        $categorias_menu = categoria_menu::where('estado', 1)->get();

        if ($categorias_menu->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorías de menú activas',
                'status' => 200
            ], 200);
        }

        return response()->json([
            'categorias_menu' => $categorias_menu,
            'status' => 200
        ], 200);
    }
}
