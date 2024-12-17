<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categoria_pro;
use App\Models\productos;
use App\Models\unidad_medida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class productos_controller extends Controller
{
    //actualiza todos los campos y parcialmete
    public function update(Request $request, $id)
    {
        $productos = productos::find($id);
        if (!$productos) {
            $data = [
                'message' => 'El id del producto no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $validation =  Validator::make($request->all(), [
            'nombre' => [
                'sometimes',
                'string',
                Rule::unique('productos')->ignore($productos->id_producto, 'id_producto'),
            ],
            'descripcion' => 'sometimes|string',
            'id_unidad_medida' => 'sometimes|exists:unidad_medida,id_unidad_medida',
            'id_usuario' => 'sometimes|exists:users,id_usuario',
            'id_categoria_pro' => 'sometimes|exists:categoria_pro,id_categoria_pro',
            'foto' => 'sometimes',
            'estado' => 'sometimes',
        ]);


        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validacion de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
            $productos->nombre = $request->nombre;
        }
        if ($request->has('descripcion')) {
            $productos->descripcion = $request->descripcion;
        }
        if ($request->has('id_unidad_medida')) {
            $productos->id_unidad_medida = $request->id_unidad_medida;
        }
        if ($request->has('id_usuario')) {
            $productos->id_usuario = $request->id_usuario;
        }
        if ($request->has('id_categoria_pro')) {
            $productos->id_categoria_pro = $request->id_categoria_pro;
        }
        if ($request->has('foto')) {
            $productos->foto = $request->foto;
        }
        if ($request->has('estado')) {
            $productos->estado = $request->estado;
        }

        $productos->save();
        $data = [
            'message' => 'producto actualizado',
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //elimina por id
    public function destroy($id)
    {
        $productos = productos::find($id);
        if (!$productos) {
            $data = [
                'message' => 'El producto no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $productos->delete();

        $data = [
            'message' => "producto eliminado",
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //consulta por id
    public function show($id)
    {
        $productos = productos::find($id);

        if (!$productos) {
            $data = [
                'message' => 'El id del productos no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $productos,
            'status' => 200

        ];
        return response()->json($data, 200);
    }


    //insercion de productos
    public function store(Request $request)
    {

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


        $categorias_pro = categoria_pro::all();

        if ($categorias_pro->isEmpty()) {
            $data = [
                'message' => 'No hay categorias de productos registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $validation =  FacadesValidator::make($request->all(), [
            'nombre' => 'required|string|unique:productos',
            'descripcion' => 'required|string',
            'id_unidad_medida' => 'required|exists:unidad_medida,id_unidad_medida',
            'id_usuario' => 'required|exists:users,id_usuario',
            'id_categoria_pro' => 'required|exists:categoria_pro,id_categoria_pro',
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


        $productos  = productos::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_unidad_medida' => $request->id_unidad_medida,
            'id_usuario' => $request->id_usuario,
            'id_categoria_pro' => $request->id_categoria_pro,
            'foto' => $request->foto
        ]);

        if (!$productos) {
            $data = [
                'message' => 'Error al crear el usuarios',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'message' => $productos,
            'status' => 201

        ];
        return response()->json($data, 201);
    }




    public function productocateg($id)
    {
        $productos = Productos::with(['unidadMedida', 'usuario', 'categoria'])
        ->where('id_categoria_pro', $id) // Suponiendo que 'categoria_id' es el nombre de la columna que almacena el ID de la categoría
        ->get();

        if ($productos->isEmpty()) {
            return response()->json([
                'message' => 'No hay productos registrados',
                'status' => 200
            ], 200);
        }

        $productosFormateados = $productos->map(function ($producto) {
            $productoArray = $producto->toArray();

            $productoArray['unidad_medida'] = $producto->unidadMedida->nombre_unidad ?? 'No asignado';
            $productoArray['usuario'] = $producto->usuario->correo ?? 'No asignado';
            $productoArray['categoria'] = $producto->categoria->nombre_categoria ?? 'No asignado';

            unset( $productoArray['id_usuario'], $productoArray['id_categoria_pro']);

            return $productoArray;
        });

        return response()->json([
            'message' => 'Productos encontrados',
            'status' => 200,
            'productos' => $productosFormateados
        ], 200);
    }

    //lista todos los productos
    public function index()
    {
        $productos = Productos::with(['unidadMedida', 'usuario', 'categoria'])->get();

        if ($productos->isEmpty()) {
            return response()->json([
                'message' => 'No hay productos registrados',
                'status' => 200
            ], 200);
        }

        $productosFormateados = $productos->map(function ($producto) {
            $productoArray = $producto->toArray();

            $productoArray['unidad_medida'] = $producto->unidadMedida->nombre_unidad ?? 'No asignado';
            $productoArray['usuario'] = $producto->usuario->correo ?? 'No asignado';
            $productoArray['categoria'] = $producto->categoria->nombre_categoria ?? 'No asignado';

            unset($productoArray['id_unidad_medida'], $productoArray['id_usuario'], $productoArray['id_categoria_pro']);

            return $productoArray;
        });

        return response()->json([
            'message' => 'Productos encontrados',
            'status' => 200,
            'productos' => $productosFormateados
        ], 200);
    }
}
