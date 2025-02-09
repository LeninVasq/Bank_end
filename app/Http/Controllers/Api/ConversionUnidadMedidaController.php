<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ConversionUnidadMedida;
use App\Models\unidad_medida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConversionUnidadMedidaController extends Controller
{
    // Obtener todas las conversiones
    public function index()
    {
        $conversiones = ConversionUnidadMedida::with(['unidadOrigen', 'unidadDestino'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $conversiones,
        ]);
    }

    // Obtener una conversión específica por ID
    public function show($id)
    {
        $conversion = ConversionUnidadMedida::with(['unidadOrigen', 'unidadDestino'])->find($id);

        if (!$conversion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversión no encontrada',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $conversion,
        ]);
    }

    // Crear una nueva conversión
    public function store(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), ConversionUnidadMedida::$rules, ConversionUnidadMedida::$messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Crear la conversión
        $conversion = ConversionUnidadMedida::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $conversion,
        ], 201);
    }

    // Actualizar una conversión existente
    public function update(Request $request, $id)
    {
        $conversion = ConversionUnidadMedida::find($id);

        if (!$conversion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversión no encontrada',
            ], 404);
        }

        // Validar los datos
        $validator = Validator::make($request->all(), ConversionUnidadMedida::$rules, ConversionUnidadMedida::$messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Actualizar la conversión
        $conversion->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $conversion,
        ]);
    }

    // Eliminar una conversión
    public function destroy($id)
    {
        $conversion = ConversionUnidadMedida::find($id);

        if (!$conversion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversión no encontrada',
            ], 404);
        }

        $conversion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Conversión eliminada correctamente',
        ]);
    }

    // Método para listar unidades de medida disponibles
    public function listarUnidadesMedida()
    {
        $unidades = unidad_medida::all();

        return response()->json([
            'status' => 'success',
            'data' => $unidades,
        ]);
    }
}
