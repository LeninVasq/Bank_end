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

        $mensajes = mensajes::create([
            'Mensaje' => $request->Mensaje,
            'correo' => $request->correo
        ]);

        if (!$mensajes) {
            return response()->json([
                'message' => 'Error al crear la categoría de menú',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'message' => 'Mensaje creado exitosamente',
            'data' => $mensajes,
            'status' => 201
        ], 201);
    }

    public function index()
    {
        $data = [];
        $mensajes = mensajes::all();

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