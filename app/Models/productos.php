<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class productos extends Model
{
    use HasFactory, Notifiable;
    

    /**
     * @var string
     */
    protected $table = 'productos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_producto';

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
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'id_unidad_medida',
        'id_usuario',
        'id_categoria_pro',
        'stock',
        'foto',
        'estado'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estado' => 'boolean'
    ];

    /**
     * Relaciones del modelo.
     */

    /**
     * Relación con la tabla unidad_medida.
     */
    public function unidadMedida()
    {
        return $this->belongsTo(unidad_medida::class, 'id_unidad_medida');
    }

    /**
     * Relación con la tabla users.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con la tabla categoria_pro.
     */
    public function categoria()
    {
        return $this->belongsTo(categoria_pro::class, 'id_categoria_pro');
    }

    
}
