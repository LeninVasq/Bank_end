<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ingreso;
use App\Models\mensajes;
use App\Models\productos;
use App\Models\unidad_medida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class mensajes_controller extends Controller
{


    public function update(Request $request, $id)
    {
        $mensaje = mensajes::find($id);
        if (!$mensaje) {
            $data = [
                'message' => 'El id del mensaje no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }




        $validation =  Validator::make($request->all(), [
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


        if ($request->has('estado')) {
            $mensaje->estado = 0;
        }

        $mensaje->save();
        $data = [
            'message' => $mensaje,
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'Mensaje' => 'required|string',
            'correo' => 'required|email'
        ]);


        
        if ($validation->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'error' => $validation->errors(),
                'status' => 400
            ], 400);
        }
        $usuario = User::where('correo', $request->correo)->pluck('id_usuario');  


        
        if ($usuario->isEmpty()) {
            return response()->json([
                'message' => 'Error el correo no esta registrado',
                'status' => 500
            ], 500);
        }
        
        $arrayValor = json_decode($usuario);

        $mensajes = mensajes::create([
            'Mensaje' => $request->Mensaje,
            'id_usuario' => $arrayValor[0]
        ]);

        if (!$mensajes) {
            return response()->json([
                'message' => 'Error al crear la solicitud',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Solicitud creada exitosamente',
            'data' => $mensajes,
            'status' => 201
        ], 201);
    }

    public function index()
    {
        $data = [];
        $mensajes =  DB::table('mensaje')->get();


        if ($mensajes->isEmpty()) {
            $data = [
                'message' => 'No hay mensajes disponibles',
                'status' => 200
            ];
        } else {
            $data = [
                'ingreso' => $mensajes,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }
}?>