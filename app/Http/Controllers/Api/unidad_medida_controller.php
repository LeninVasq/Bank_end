<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\unidad_medida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class unidad_medida_controller extends Controller
{
    //actualiza todos los campos y parcialmete
    public function update(Request $request, $id)
    {
        $unidad_medida = unidad_medida::find($id);
        if (!$unidad_medida) {
            $data = [
                'message' => 'El id de la unidad de medida no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }




        $validation =  Validator::make($request->all(), [
            'nombre_unidad' => [
                'sometimes',
                Rule::unique('unidad_medida')->ignore($unidad_medida->id_unidad_medida, 'id_unidad_medida'),
            ],

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


        if ($request->has('nombre_unidad')) {
            $unidad_medida->nombre_unidad = $request->nombre_unidad;
        }
        if ($request->has('estado')) {
            $unidad_medida->estado = $request->estado;
        }

        $unidad_medida->save();
        $data = [
            'message' => 'Se ha actualizado la unidad de medida',
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //elimina por id
    public function destroy($id)
    {
        $unidad_medida = unidad_medida::find($id);
        if (!$unidad_medida) {
            $data = [
                'message' => 'El id de la unidad de medida no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $unidad_medida->delete();

        $data = [
            'message' => "Se ha eliminado el registro de unidad de medida ",
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //consulta por id
    public function show($id)
    {
        $unidad_medida = unidad_medida::find($id);
        if (!$unidad_medida) {
            $data = [
                'mensaje' => 'El id de la unidad de medida no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $data = [
            'mensaje' => $unidad_medida,
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //insercion de usuarios
    public function store(Request $request)
    {



        $validation =  Validator::make($request->all(), [
            'nombre_unidad' => 'required|string|unique:unidad_medida'
        ]);

        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


        $unidad_medida  = unidad_medida::create([

            'nombre_unidad' => $request->nombre_unidad
        ]);

        if (!$unidad_medida) {
            $data = [
                'message' => 'Error al crear el usuarios',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'message' => $unidad_medida,
            'status' => 201

        ];
        return response()->json($data, 201);
    }


    //lista todos las unidades de medidas
    public function index()
    {
        $data = [];
        $unidad_medida = unidad_medida::all();

        if ($unidad_medida->isEmpty()) {
            $data = [
                'message' => 'No hay unidades de medidas registrados',
                'status' => 200
            ];
        } else {
            $data = [
                'unidad_medida' => $unidad_medida,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }
}
