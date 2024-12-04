<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categoria_recetas;
use App\Models\recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class recetas_controller extends Controller
{
    //actualiza todos los campos y parcialmete
    public function update(Request $request, $id)
    {
        $recetas = recetas::find($id);
        if (!$recetas) {
            $data = [
                'message' => 'El id del producto no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $validation =  Validator::make($request->all(), [
            'id_usuario' => 'sometimes|exists:users,id_usuario',
            'id_categoria_recetas' => 'sometimes|exists:categoria_recetas,id_categoria_recetas',
            'nombre_receta' => 'sometimes|string|unique:recetas',
            'descripcion' => 'sometimes|string',
            'tiempo_preparacion' => 'sometimes|integer',
            'numero_porciones' => 'sometimes|integer',
            'dificultad' => 'sometimes|string',
            'foto' => 'sometimes|string',
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
            'message' => 'receta actualizada',
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //elimina por id
    public function destroy($id)
    {
        $recetas = recetas::find($id);
        if (!$recetas) {
            $data = [
                'message' => 'La recetas no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $recetas->delete();

        $data = [
            'message' => "producto eliminado",
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //consulta por id
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


    //insercion de productos
    public function store(Request $request)
    {

        $data = [];
        $categoria_recetas = categoria_recetas::all();

        if ($categoria_recetas->isEmpty()) {
            $data = [
                'mensaje' => 'No hay categorias de recetas registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $validation =  Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id_usuario',
            'id_categoria_recetas' => 'required|exists:categoria_recetas,id_categoria_recetas',
            'nombre_receta' => 'required|string|unique:recetas',
            'descripcion' => 'required|string',
            'tiempo_preparacion' => 'required|integer',
            'numero_porciones' => 'required|integer',
            'dificultad' => 'required|string',
            'foto' => 'required|string',

        ]);

        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validacion de datos',
                'error' => $validation->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


        $data = [
            'id_usuario' => $request->id_usuario,
            'id_categoria_recetas' => $request->id_categoria_recetas,
            'nombre_receta' => $request->nombre_receta,
            'descripcion' => $request->descripcion,
            'tiempo_preparacion' => $request->tiempo_preparacion,
            'numero_porciones' => $request->numero_porciones,
            'dificultad' => $request->dificultad,
            'foto' => $request->foto,
        ];

        $recetas = recetas::create($data);


        if (!$recetas) {
            $data = [
                'message' => 'Error al crear la recetas',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'message' => $recetas,
            'status' => 201

        ];
        return response()->json($data, 201);
    }


    //lista todos las recetas
    public function index()
    {
        $data = [];
        $recetas = recetas::all();

        if ($recetas->isEmpty()) {
            $data = [
                'message' => 'No hay recetas registradas',
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
