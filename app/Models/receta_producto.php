<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class receta_producto extends Model
{
    use HasFactory, Notifiable;

    // Definir el nombre de la tabla si es diferente a 'receta_productos'
    protected $table = 'receta_producto';

    // Definir la clave primaria si es diferente a 'id'
    protected $primaryKey = 'id_recetas_producto';


    public $timestamps = true;

    protected $fillable = [
        'id_producto',
        'id_receta',
        'cantidad',
        'estado'
    ];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(productos::class, 'id_producto', 'id_producto');
    }

    // Relación con el modelo Receta
    public function receta()
    {
        return $this->belongsTo(recetas::class, 'id_receta', 'id_recetas');
    }

    protected $casts = [
        'estado' => 'boolean',
    ];
    
}
