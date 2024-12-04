<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ingreso;
use App\Models\productos;
use App\Models\unidad_medida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ingreso_controller extends Controller
{
    //actualiza todos los campos y parcialmete
    public function update(Request $request, $id)
    {
        $ingreso = ingreso::find($id);
        if (!$ingreso) {
            $data = [
                'message' => 'El id del producto no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $validation =  Validator::make($request->all(), [
            'id_producto' => 'sometimes|exists:productos,id_producto',
            'id_unidad_medida' => 'sometimes|exists:unidad_medida,id_unidad_medida',
            'tipo_movimiento' => 'sometimes|string',
            'costo_unitario' => 'sometimes|numeric',
            'costo_total' => 'sometimes|numeric',
            'cantidad' => 'sometimes|integer',
            'motivo' => 'sometimes|string',
            'id_usuario' => 'sometimes|exists:users,id_usuario',
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

        if ($request->has('id_producto')) {
            $ingreso->id_producto = $request->id_producto;
        }
        if ($request->has('id_unidad_medida')) {
            $ingreso->id_unidad_medida = $request->id_unidad_medida;
        }
        if ($request->has('tipo_movimiento')) {
            $ingreso->tipo_movimiento = $request->tipo_movimiento;
        }
        if ($request->has('costo_unitario')) {
            $ingreso->costo_unitario = $request->costo_unitario;
        }
        if ($request->has('costo_total')) {
            $ingreso->costo_total = $request->costo_total;
        }
        if ($request->has('cantidad')) {
            $ingreso->cantidad = $request->cantidad;
        }
        if ($request->has('motivo')) {
            $ingreso->motivo = $request->motivo;
        } 
        if ($request->has('id_usuario')) {
            $ingreso->id_usuario = $request->id_usuario;
        }
        if ($request->has('estado')) {
            $ingreso->estado = $request->estado;
        }
        
       

        $ingreso->save();
        $data = [
            'message' => 'producto actualizado',
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //elimina por id
    public function destroy($id)
    {
        $ingreso = ingreso::find($id);
        if (!$ingreso) {
            $data = [
                'message' => 'El ingreso no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $ingreso->delete();

        $data = [
            'message' => "producto eliminado",
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //consulta por id
    public function show($id)
    {
        $ingreso = ingreso::find($id);
        if (!$ingreso) {
            $data = [
                'message' => 'El id del ingreso no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $ingreso,
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //insercion de productos
    public function store(Request $request)
    {

        $data = [];
        $productos = productos::all();

        if ($productos->isEmpty()) {
            $data = [
                'mensaje' => 'No hay productos registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }


        $data = [];
        $unidad_medida = unidad_medida::all();

        if ($unidad_medida->isEmpty()) {
            $data = [
                'mensaje' => 'No hay unidades de medidas registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $User = User::all();

        if ($User->isEmpty()) {
            $data = [
                'mensaje' => 'No hay usuarios registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }


        $validation =  Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'id_unidad_medida' => 'required|exists:unidad_medida,id_unidad_medida',
            'tipo_movimiento' => 'required|string',
            'costo_unitario' => 'required|numeric',
            'costo_total' => 'sometimes|numeric',
            'cantidad' => 'required|integer',
            'motivo' => 'sometimes|string',
            'id_usuario' => 'required|exists:users,id_usuario',

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
            'id_producto' => $request->id_producto,
            'id_unidad_medida' => $request->id_unidad_medida,
            'tipo_movimiento' => $request->tipo_movimiento,
            'costo_unitario' => $request->costo_unitario,
            'cantidad' => $request->cantidad,
            'id_usuario' => $request->id_usuario,
        ];

        if ($request->has('costo_total')) {
            $data['costo_total'] = $request->costo_total;
        }

        if ($request->has('motivo')) {
            $data['motivo'] = $request->motivo;
        }

        $ingreso = ingreso::create($data);


        if (!$ingreso) {
            $data = [
                'message' => 'Error al crear el ingreso',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'message' => $ingreso,
            'status' => 201

        ];
        return response()->json($data, 201);
    }


    //lista todos los productos
    public function index()
    {
        $data = [];
        $ingreso = ingreso::all();

        if ($ingreso->isEmpty()) {
            $data = [
                'message' => 'No hay ingresos registrados',
                'status' => 200
            ];
        } else {
            $data = [
                'ingreso' => $ingreso,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }
}
