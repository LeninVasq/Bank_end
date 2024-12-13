<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\productos;
use App\Models\receta_producto;
use App\Models\recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class receta_producto_controller extends Controller
{
    // Actualiza todos los campos y parcialmente
    public function update(Request $request, $id)
    {
        $receta_producto = receta_producto::find($id);
        if (!$receta_producto) {
            $data = [
                'message' => 'El id de la receta_producto no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validation = Validator::make($request->all(), [
            'id_producto' => 'sometimes|exists:productos,id_producto',
            'id_recetas' => 'sometimes|exists:recetas,id_recetas',  // Corregido: ahora valida la tabla recetas con id_recetas
            'cantidad' => 'sometimes|integer',
            'estado' => 'sometimes'
        ]);

        if ($validation->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Solo actualiza los campos que se proporcionan
        if ($request->has('id_producto')) {
            $receta_producto->id_producto = $request->id_producto;
        }
        if ($request->has('id_recetas')) {  // Corregido: actualiza con id_recetas
            $receta_producto->id_receta = $request->id_recetas;
        }
        if ($request->has('cantidad')) {
            $receta_producto->cantidad = $request->cantidad;
        }
        if ($request->has('estado')) {
            $receta_producto->estado = $request->estado;
        }

        $receta_producto->save();

        $data = [
            'message' => 'Receta producto actualizado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Elimina por id
    public function destroy($id)
    {
        $receta_producto = receta_producto::find($id);
        if (!$receta_producto) {
            $data = [
                'message' => 'El id de la receta_producto no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $receta_producto->delete();

        $data = [
            'message' => "Se ha eliminado el registro de receta_producto",
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Consulta por id
    public function show($id)
    {
        $receta_producto = receta_producto::find($id);
        if (!$receta_producto) {
            $data = [
                'message' => 'El id de la receta_producto no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $receta_producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Inserción de receta_producto
    public function store(Request $request)
    {
        // Validación para asegurarse de que los IDs existen en las tablas correspondientes
        $validation = Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'id_receta' => 'required|exists:recetas,id_recetas',  
            'cantidad' => 'required|integer',
        ]);

        if ($validation->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Crear el nuevo registro en receta_producto
        $receta_producto = receta_producto::create([
            'id_producto' => $request->id_producto,
            'id_receta' => $request->id_receta,  // Cambiado a id_recetas si es necesario
            'cantidad' => $request->cantidad
        ]);

        if (!$receta_producto) {
            $data = [
                'message' => 'Error al crear el registro en receta_producto',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Receta producto creado exitosamente',
            'receta_producto' => $receta_producto,  // Devolvemos el objeto creado para información adicional
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    // Lista todas las categorías de receta_producto
    public function index()
    {
        $receta_producto = receta_producto::all();

        if ($receta_producto->isEmpty()) {
            $data = [
                'message' => 'No hay receta_producto registrados',
                'status' => 200
            ];
        } else {
            $data = [
                'receta_producto' => $receta_producto,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }

    // Método para obtener los productos por id_receta
    public function getProductosPorReceta($id_receta)
    {
        // Buscar los registros de receta_producto para la receta dada
        $receta_producto = receta_producto::where('id_receta', $id_receta)
            ->with('producto')  // Cargar la relación con los productos
            ->get();

        if ($receta_producto->isEmpty()) {
            $data = [
                'message' => 'No se encontraron productos para esta receta',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Devolver los productos asociados a la receta
        $data = [
            'message' => 'Productos encontrados para la receta',
            'productos' => $receta_producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
