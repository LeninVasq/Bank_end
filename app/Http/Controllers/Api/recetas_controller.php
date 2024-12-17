<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class recetas_controller extends Controller
{
    // Inserción de receta
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id_usuario',
            'id_categoria_recetas' => 'required|exists:categoria_recetas,id_categoria_recetas',
            'nombre_receta' => 'required|string|unique:recetas',
            'descripcion' => 'required|string',
            'tiempo_preparacion' => 'required|integer',
            'numero_porciones' => 'required|integer',
            'dificultad' => 'required|string',
            'foto' => 'sometimes', 
        ]);

        if ($validation->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $recetas = recetas::create([
            'id_usuario' => $request->id_usuario,
            'id_categoria_recetas' => $request->id_categoria_recetas,
            'nombre_receta' => $request->nombre_receta,
            'descripcion' => $request->descripcion,
            'tiempo_preparacion' => $request->tiempo_preparacion,
            'numero_porciones' => $request->numero_porciones,
            'dificultad' => $request->dificultad,
            'foto' => $request->foto
        ]);

        if (!$recetas) {
            $data = [
                'message' => 'Error al crear la receta',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Receta creada',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    // Actualización de receta
    public function update(Request $request, $id)
    {
        $recetas = recetas::find($id);
        if (!$recetas) {
            $data = [
                'message' => 'El id de la receta no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validation = Validator::make($request->all(), [
            'id_usuario' => 'sometimes|exists:users,id_usuario',
            'id_categoria_recetas' => 'sometimes|exists:categoria_recetas,id_categoria_recetas',
            'nombre_receta' => 'sometimes|string|unique:recetas',
            'descripcion' => 'sometimes|string',
            'tiempo_preparacion' => 'sometimes|integer',
            'numero_porciones' => 'sometimes|integer',
            'dificultad' => 'sometimes|string',
            'foto' => 'sometimes', // Foto opcional
            'estado' => 'sometimes'
        ]);

        if ($validation->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('id_usuario')) {
            $recetas->id_usuario = $request->id_usuario;
        }
        if ($request->has('id_categoria_recetas')) {
            $recetas->id_categoria_recetas = $request->id_categoria_recetas;
        }
        if ($request->has('nombre_receta')) {
            $recetas->nombre_receta = $request->nombre_receta;
        }
        if ($request->has('descripcion')) {
            $recetas->descripcion = $request->descripcion;
        }
        if ($request->has('tiempo_preparacion')) {
            $recetas->tiempo_preparacion = $request->tiempo_preparacion;
        }
        if ($request->has('numero_porciones')) {
            $recetas->numero_porciones = $request->numero_porciones;
        }
        if ($request->has('dificultad')) {
            $recetas->dificultad = $request->dificultad;
        }

        if ($request->has('foto')) {
            $recetas->foto = $request->foto;
        }

        if ($request->has('estado')) {
            $recetas->estado = $request->estado;
        }

        $recetas->save();

        $data = [
            'message' => 'Receta actualizada',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Eliminar receta por ID
    public function destroy($id)
    {
        $recetas = recetas::find($id);

        if (!$recetas) {
            $data = [
                'message' => 'El id de la receta no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $recetas->delete();

        $data = [
            'message' => "Se ha eliminado el registro de receta",
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Consultar receta por ID
    public function show($id)
    {
        $recetas = recetas::find($id);

        if (!$recetas) {
            $data = [
                'message' => 'El id de la receta no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $recetas,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Listar todas las recetas
    public function index(Request $request)
    {
        $data = [];
        $categoriaId = $request->query('categoria_id'); // Obtener el parametro de categoria_id desde la URL
        
        if ($categoriaId) {
            // Si se proporciona el categoria_id, filtramos las recetas por esa categoría
            $recetas = recetas::where('id_categoria_recetas', $categoriaId)->get();
        } else {
            // Si no se proporciona un categoria_id, obtenemos todas las recetas
            $recetas = recetas::all();
        }
    
        if ($recetas->isEmpty()) {
            $data = [
                'message' => 'No hay recetas registradas para esta categoría',
                'status' => 200
            ];
        } else {
            $data = [
                'recetas' => $recetas,
                'status' => 200
            ];
        }
        
        return response()->json($data, 200);
    }
    
    
}