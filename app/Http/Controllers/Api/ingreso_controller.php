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
            'id_usuario' => 'required|exists:users,id_usuario',
            'tipo_movimiento' => 'required|string',
            'costo_unitario' => 'required|numeric',
            'costo_total' => 'sometimes|numeric',
            'cantidad' => 'required|integer',
            'motivo' => 'sometimes|string',

        ]);

        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validacion de datos',
                    'error' => $validation->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


      

        if ($request->has('motivo')) {
           $motivo = $request->motivo;
        }
        else{
            $motivo= "Ninguno";
        }

        // Insertar el ingreso usando Eloquent
        $ingreso = Ingreso::create([
            'id_producto'     => $request->id_producto,
            'tipo_movimiento' =>  $request->tipo_movimiento, 
            'costo_unitario'  => $request->costo_unitario,
            'cantidad'        => $request->cantidad,
            'id_usuario'      => $request->id_usuario,
            'costo_total'     => $request->costo_unitario * $request->cantidad,
            'motivo'          => $motivo,
        ]);

        $producto = productos::find($ingreso->id_producto);
        $stockActual = $producto->stock;

        if($request->tipo_movimiento == "Entrada"){
        $nuevoStock = $stockActual + $ingreso->cantidad;
        }
        elseif ($request->tipo_movimiento == "Salida") {
            if($ingreso->cantidad > $stockActual){
                $data = [
                    'message' => 'La cantidad de productos a retirar excede la cantidad del stock',
                    'status' => 400
                ];
                return response()->json($data, 400);
            }
            $nuevoStock = $stockActual - $ingreso->cantidad;
        }



        $producto->update(['stock' => $nuevoStock]);

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
