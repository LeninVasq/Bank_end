<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categoria_pro;
use App\Models\categorias_pro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class categoria_pro_controller extends Controller
{
     //actualiza todos los campos y parcialmete
     public function update(Request $request, $id)
     {
         $categorias_pro = categoria_pro::find($id);
         if (!$categorias_pro) {
             $data = [
                 'message' => 'El id de la categoria de recetas no existe',
                 'status' => 404
 
             ];
             return response()->json($data, 404);
         }
 
 
         
 
         $validation =  Validator::make($request->all(), [
             
             'nombre_categoria' => [
                'sometimes',
                Rule::unique('categoria_pro')->ignore($categorias_pro->id_categoria_pro, 'id_categoria_pro'),
            ],

             'descripcion' => 'sometimes|string',
             'foto' => 'sometimes',
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
 
         if ($request->has('nombre_categoria')) {
         $categorias_pro->nombre_categoria = $request->nombre_categoria; 
         }
         if ($request->has('descripcion')) {
         $categorias_pro->descripcion = $request->descripcion; 
         }

         if ($request->has('foto')) {
            $categorias_pro->foto = $request->foto; 
            }
         if ($request->has('estado')) {
         $categorias_pro->estado = $request->estado; 
         }
         
         $categorias_pro->save();
         $data = [
            'message' => 'Categorias productos actualizado',
             'status' => 200
 
         ];
         return response()->json($data, 200);
     }
 
     //elimina por id
     public function destroy($id)
     {
         $categorias_pro = categoria_pro::find($id);
         if (!$categorias_pro) {
             $data = [
                 'message' => 'El id de la categoria de productos no existe',
                 'status' => 404
 
             ];
             return response()->json($data, 404);
         }
 
         $categorias_pro->delete();
 
         $data = [
             'message' => "Se ha eliminado el registro de categoria productos ",
             'status' => 200
 
         ];
         return response()->json($data, 200);
     }
 
 
     //consulta por id
     public function show($id)
     {
         $categorias_pro = categoria_pro::find($id);
         if (!$categorias_pro) {
             $data = [
                 'message' => 'El id de la categoria de productos no existe',
                 'status' => 404
 
             ];
             return response()->json($data, 404);
         }
 
         $data = [
             'message' => $categorias_pro,
             'status' => 200
 
         ];
         return response()->json($data, 200);
     }
 
 
     //insercion de categorias de recetas
     public function store(Request $request)
     {
 
         $validation =  Validator::make($request->all(), [
             'nombre_categoria' => 'required|string|unique:categoria_pro',
             'descripcion' => 'required|string',
             'foto' => 'required'

         ]);
 
         if ($validation->fails()) {
 
             $data = [
                 'message' => 'Error en la validacion de datos',
                 'error' => $validation->errors(),
                 'status' => 400
 
             ];
             return response()->json($data, 400);
         }
 
 
         $categorias_pro  = categoria_pro::create([
           
             'nombre_categoria' => $request->nombre_categoria,
             'descripcion' => $request->descripcion,
             'foto' => $request->foto

         ]);
 
         if (!$categorias_pro) {
             $data = [
                 'message' => 'Error al crear el usuarios',
                 'status' => 500
 
             ];
             return response()->json($data, 500);
         }
 
 
         $data = [
             'message' => $categorias_pro,
             'status' => 201
 
         ];
         return response()->json($data, 201);
     }
 
 
     //lista todas las categorias de recetas
     public function index()
     {
         $data = [];


         $categorias_pro = DB::table('categoria_count(productos)')->get();
         
          
         if ($categorias_pro->isEmpty()) {
             $data = [
                 'message' => 'No hay categorias de productos registrados',
                 'status' => 200
             ];
         } else {
             $data = [
                 'categorias_productos' => $categorias_pro,
                 'status' => 200
             ];
         }
         return response()->json($data, 200);
     }


     public function listasolo1()
     {
         $data = [];
         $categorias_pro = categoria_pro::where('estado', 1)->get();
 
         if ($categorias_pro->isEmpty()) {
             $data = [
                 'message' => 'No hay categorias de productos registrados',
                 'status' => 200
             ];
         } else {
             $data = [
                 'categorias_productos' => $categorias_pro,
                 'status' => 200
             ];
         }
         return response()->json($data, 200);
     }
}
