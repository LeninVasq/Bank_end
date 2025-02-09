<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionUnidadMedida extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'conversiones_unidad_medida';

    // Campos asignables masivamente
    protected $fillable = [
        'id_unidad_origen',
        'id_unidad_destino',
        'factor',
    ];

    // Campos ocultos en respuestas JSON
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Relación con la tabla `unidad_medida` (unidad de origen)
    public function unidadOrigen()
    {
        return $this->belongsTo(unidad_medida::class, 'id_unidad_origen', 'id_unidad_medida');
    }

    public function unidadDestino()
    {
        return $this->belongsTo(unidad_medida::class, 'id_unidad_destino', 'id_unidad_medida');
    }

    // Validaciones
    public static $rules = [
        'id_unidad_origen' => 'required|exists:unidad_medida,id_unidad_medida',
        'id_unidad_destino' => 'required|exists:unidad_medida,id_unidad_medida',
        'factor' => 'required|numeric|min:0',
    ];

    // Mensajes de validación personalizados
    public static $messages = [
        'id_unidad_origen.required' => 'La unidad de origen es obligatoria.',
        'id_unidad_origen.exists' => 'La unidad de origen seleccionada no existe.',
        'id_unidad_destino.required' => 'La unidad de destino es obligatoria.',
        'id_unidad_destino.exists' => 'La unidad de destino seleccionada no existe.',
        'factor.required' => 'El factor de conversión es obligatorio.',
        'factor.numeric' => 'El factor de conversión debe ser un número.',
        'factor.min' => 'El factor de conversión no puede ser negativo.',
    ];
}
