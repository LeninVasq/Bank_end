<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasoReceta extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'pasos_receta'; // El nombre de la tabla en la base de datos

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_paso'; // La clave primaria de la tabla

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Usar los timestamps (created_at y updated_at)

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_recetas',
        'paso_numero',
        'descripcion',
    ];

    /**
     * Definir la relación con la receta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receta()
    {
        return $this->belongsTo(Recetas::class, 'id_recetas'); // Cambié "recetas" por "Recetas"
    }
}
