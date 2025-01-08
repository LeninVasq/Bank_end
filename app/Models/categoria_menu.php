<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoria_menu extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'categoria_menu'; // Nombre de la tabla asociada al modelo

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_categoria_menu'; // Actualizado a 'id_categoria_menu'

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'foto',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

}
