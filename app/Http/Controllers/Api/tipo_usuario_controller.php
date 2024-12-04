<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tipo_usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class tipo_usuario_controller extends Controller
{


   

    //actualizacion de todos los campos
    public function update(Request $request, $id)
    {
        
        $tipo_usuario = tipo_usuario::find($id);
        if (!$tipo_usuario) {
            $data = [
                'mensaje' => 'El id del tipo de usuario no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $validation =  Validator::make($request->all(), [
            
            'tipo' => [
                'sometimes',
                'string',         
                'max:255',
                Rule::unique('tipo_usuario')->ignore($tipo_usuario->id_tipo_usuario, 'id_tipo_usuario'),
            ],
            'estado' => 'sometimes|string',
        ]);

        
        if ($validation->fails()) {

            $data = [
                'mensaje' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }


        if ($request->has('tipo')) {
            $tipo_usuario->tipo = $request->tipo;
        }

        if ($request->has('estado')) {
            $tipo_usuario->estado = $request->estado;
        }
        

        $tipo_usuario->save();
        $data = [
            'mensaje' => 'Los campos de tipo de usuario ha sido actualizado',
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //eliminar por id
    public function destroy($id)
    {
        $tipo_usuario = tipo_usuario::find($id);
        if (!$tipo_usuario) {
            $data = [
                'mensaje' => 'El id del tipo de usuario no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $tipo_usuario->delete();

        $data = [
            'mensaje' => "El tipo de usuario se ha eliminado",
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //consulta por id
    public function show($id)
    {
        $tipo_usuario = tipo_usuario::find($id);
        if (!$tipo_usuario) {
            $data = [
                'mensaje' => 'El id del tipo de usuario no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $data = [
            'mensaje' => $tipo_usuario,
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //insercion de tipo
    public function store(Request $request)
    {

        $validation =  Validator::make($request->all(), [
            'tipo' => 'required|unique:tipo_usuario'
        ]);

        if ($validation->fails()) {

            $data = [
                'mensaje' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


        $tipo_usuario  = tipo_usuario::create([
            'tipo' => $request->tipo
        ]);

        if (!$tipo_usuario) {
            $data = [
                'mensaje' => 'Error al crear el tipo de usuarios',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'mensaje' => $tipo_usuario,
            'status' => 201

        ];
        return response()->json($data, 201);
    }

    //consulta general de tipo de usuarios
    public function index()
    {
        $data = [];
        $tipo_usuario = tipo_usuario::all();

        if ($tipo_usuario->isEmpty()) {
            $data = [
                'mensaje' => 'No hay tipos de usuarios registrados',
                'status' => 200
            ];

        } else {
            $data = [
                'Tipo de usuarios' => $tipo_usuario,
                'status' => 200
            ];
        }
        return response()->json($data,200);
    
    }
}
