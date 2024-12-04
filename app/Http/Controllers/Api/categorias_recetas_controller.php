<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categoria_recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class categorias_recetas_controller extends Controller
{
    //actualiza todos los campos y parcialmete
    public function update(Request $request, $id)
    {
        $categoria_recetas = categoria_recetas::find($id);
        if (!$categoria_recetas) {
            $data = [
                'message' => 'El id de la categoria de recetas no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }


        

        $validation =  Validator::make($request->all(), [
            'nombre' => 'sometimes|string',
            'nombre' => [
                'sometimes',
                Rule::unique('categoria_recetas')->ignore($categoria_recetas->id_categoria_recetas, 'id_categoria_recetas'),
            ],
            'descripcion' => 'sometimes|string',
            'estado' => 'sometimes'
        ]);


        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
        $categoria_recetas->nombre = $request->nombre; 
        }
        if ($request->has('descripcion')) {
        $categoria_recetas->descripcion = $request->descripcion; 
        }
        if ($request->has('estado')) {
        $categoria_recetas->estado = $request->estado; 
        }
        
        $categoria_recetas->save();
        $data = [
            'message' => 'Categorias recetas actualizado',
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //elimina por id
    public function destroy($id)
    {
        $categoria_recetas = categoria_recetas::find($id);
        if (!$categoria_recetas) {
            $data = [
                'message' => 'El id de la categoria de recetas no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $categoria_recetas->delete();

        $data = [
            'message' => "Se ha eliminado el registro de categoria recetas ",
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //consulta por id
    public function show($id)
    {
        $categoria_recetas = categoria_recetas::find($id);
        if (!$categoria_recetas) {
            $data = [
                'message' => 'El id de la categoria de recetas no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $categoria_recetas,
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //insercion de categorias de recetas
    public function store(Request $request)
    {

        
        
        $validation =  Validator::make($request->all(), [
            'nombre' => 'required|string|unique:categoria_recetas',
            'descripcion' => 'required|string',
        ]);

        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


        $categoria_recetas  = categoria_recetas::create([
          
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        if (!$categoria_recetas) {
            $data = [
                'message' => 'Error al crear el usuarios',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'message' => $categoria_recetas,
            'status' => 201

        ];
        return response()->json($data, 201);
    }


    //lista todas las categorias de recetas
    public function index()
    {
        $data = [];
        $categoria_recetas = categoria_recetas::all();

        if ($categoria_recetas->isEmpty()) {
            $data = [
                'message' => 'No hay categorias de recetas registrados',
                'status' => 200
            ];
        } else {
            $data = [
                'categoria_recetas' => $categoria_recetas,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }
}
