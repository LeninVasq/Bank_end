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
     //actualiza todos los campos y parcialmete
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
 
 
         
 
         $validation =  Validator::make($request->all(), [
             'id_producto' => 'sometimes|exists:productos,id_producto',
            'id_receta' => 'sometimes|exists:unidad_medida,id_unidad_medida',
            'cantidad' => 'sometimes|integer',
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
 
         if ($request->has('id_producto')) {
         $receta_producto->id_producto = $request->id_producto; 
         }
         if ($request->has('id_receta')) {
         $receta_producto->id_receta = $request->id_receta; 
         }
         if ($request->has('cantidad')) {
         $receta_producto->cantidad = $request->cantidad; 
         }
         if ($request->has('estado')) {
         $receta_producto->estado = $request->estado; 
         }
         
         $receta_producto->save();
         $data = [
             'message' => 'receta_producto actualizado',
             'status' => 200
 
         ];
         return response()->json($data, 200);
     }
 
     //elimina por id
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
             'message' => "Se ha eliminado el registro de receta_producto ",
             'status' => 200
 
         ];
         return response()->json($data, 200);
     }
 
 
     //consulta por id
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
 
 
     //insercion de categorias de recetas
     public function store(Request $request)
     {
 
         
        $productos = productos::all();

        if ($productos->isEmpty()) {
            $data = [
                'mensaje' => 'No hay productos registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $recetas = recetas::all();

        if ($recetas->isEmpty()) {
            $data = [
                'mensaje' => 'No hay recetas registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }
         
         $validation =  Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'id_receta' => 'required|exists:unidad_medida,id_unidad_medida',
            'cantidad' => 'required|integer',
         ]);
 
         if ($validation->fails()) {
 
             $data = [
                 'message' => 'Error en la validation de datos',
                 'error' => $validation->errors(),
                 'status' => 400
 
             ];
             return response()->json($data, 400);
         }
 
 
         $receta_producto  = receta_producto::create([
             'id_producto' => $request->id_producto,
             'id_receta' => $request->id_receta,
             'cantidad' => $request->cantidad
         ]);
 
         if (!$receta_producto) {
             $data = [
                 'message' => 'Error al crear el usuarios',
                 'status' => 500
 
             ];
             return response()->json($data, 500);
         }
 
 
         $data = [
             'message' => $receta_producto,
             'status' => 201
 
         ];
         return response()->json($data, 201);
     }
 
 
     //lista todas las categorias de recetas
     public function index()
     {
         $data = [];
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
}
