<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingreso extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla si no sigue la convención de pluralización
    protected $table = 'ingreso';

/**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_ingreso';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'id_producto',
        'id_unidad_medida',
        'tipo_movimiento',
        'costo_unitario',
        'costo_total',
        'cantidad',
        'motivo',
        'id_usuario',
        'estado',
    ];

    // Definir las relaciones con otros modelos
    public function producto()
    {
        return $this->belongsTo(productos::class, 'id_producto');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(unidad_medida::class, 'id_unidad_medida');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function setCostoTotalAttribute()
    {
        $this->attributes['costo_total'] = $this->costo_unitario * $this->cantidad;
    }

    protected $casts = [
        'estado' => 'boolean'
    ];
}
