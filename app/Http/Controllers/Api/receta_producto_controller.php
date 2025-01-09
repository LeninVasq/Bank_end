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
    // Actualiza todos los campos y parcialmente
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

        $validation = Validator::make($request->all(), [
            'id_producto' => 'sometimes|exists:productos,id_producto',
            'id_recetas' => 'sometimes|exists:recetas,id_recetas',
            'cantidad' => 'sometimes|numeric',  // Cambiado a numeric
            'estado' => 'sometimes'
        ]);

        if ($validation->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Solo actualiza los campos que se proporcionan
        if ($request->has('id_producto')) {
            $receta_producto->id_producto = $request->id_producto;
        }
        if ($request->has('id_recetas')) {
            $receta_producto->id_receta = $request->id_recetas;
        }
        if ($request->has('cantidad')) {
            $receta_producto->cantidad = round($request->cantidad, 2);  // Redondea a 2 decimales
        }
        if ($request->has('estado')) {
            $receta_producto->estado = $request->estado;
        }

        $receta_producto->save();

        $data = [
            'message' => 'Receta producto actualizado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Elimina por id
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
            'message' => "Se ha eliminado el registro de receta_producto",
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // Consulta por id
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

    // Inserción de receta_producto
    // Inserción de receta_producto
public function store(Request $request)
{
    // Validación para asegurarse de que los IDs existen en las tablas correspondientes
    $validation = Validator::make($request->all(), [
        'id_producto' => 'required|exists:productos,id_producto',
        'id_receta' => 'required|exists:recetas,id_recetas',
        'cantidad' => 'required|numeric',  // Cambiado a numeric
    ]);

    if ($validation->fails()) {
        $data = [
            'message' => 'Error en la validación de datos',
            'error' => $validation->errors(),
            'status' => 400
        ];
        return response()->json($data, 400);
    }

    // Verificar si el producto ya está agregado a la receta
    $existeProductoEnReceta = receta_producto::where('id_receta', $request->id_receta)
        ->where('id_producto', $request->id_producto)
        ->exists();

    if ($existeProductoEnReceta) {
        $data = [
            'message' => 'Este producto ya está agregado a la receta.',
            'status' => 400
        ];
        return response()->json($data, 400);  // Error si el producto ya está en la receta
    }

    // Crear el nuevo registro en receta_producto
    $receta_producto = receta_producto::create([
        'id_producto' => $request->id_producto,
        'id_receta' => $request->id_receta,
        'cantidad' => round($request->cantidad, 2),  // Redondea a 2 decimales
    ]);

    if (!$receta_producto) {
        $data = [
            'message' => 'Error al crear el registro en receta_producto',
            'status' => 500
        ];
        return response()->json($data, 500);
    }

    $data = [
        'message' => 'Receta producto creado exitosamente',
        'receta_producto' => $receta_producto,
        'status' => 201
    ];
    return response()->json($data, 201);
}


    // Lista todas las categorías de receta_producto
    public function index()
    {
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

    // Método para obtener los productos por id_receta
    public function getProductosPorReceta($id_receta)
    {
        // Buscar los registros de receta_producto para la receta dada
        $receta_producto = receta_producto::where('id_receta', $id_receta)
            ->with('producto')  // Cargar la relación con los productos
            ->get();

        if ($receta_producto->isEmpty()) {
            $data = [
                'message' => 'No se encontraron productos para esta receta',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Devolver los productos asociados a la receta
        $data = [
            'message' => 'Productos encontrados para la receta',
            'productos' => $receta_producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function showRecetaConProductos($id_receta)
    {
        // Buscar la receta con los productos asociados
        $receta = recetas::with(['recetaProductos.producto' => function ($query) {
            // Solo cargar la relación necesaria de unidadMedida
            $query->with('unidadMedida');
        }])->find($id_receta);

        if (!$receta) {
            return response()->json([
                'message' => 'La receta no existe',
                'status' => 404
            ], 404);
        }

        // Formatear la respuesta para que contenga tanto la receta como los productos con sus detalles
        $recetaFormateada = $receta->toArray();
        $recetaFormateada['productos'] = $receta->recetaProductos->map(function ($recetaProducto) {
            $producto = $recetaProducto->producto; // Obtenemos el producto asociado
            $productoArray = $producto->toArray();

            // Solo formateamos la relación de unidadMedida
            $productoArray['unidad_medida'] = $producto->unidadMedida->nombre_unidad ?? 'No asignado';

            // Eliminar campos innecesarios para la respuesta
            unset($productoArray['id_unidad_medida'], $productoArray['id_usuario'], $productoArray['id_categoria_pro']);
            return $productoArray;
        });

        return response()->json([
            'message' => 'Receta encontrada con productos',
            'status' => 200,
            'receta' => $recetaFormateada
        ], 200);
    }
}
