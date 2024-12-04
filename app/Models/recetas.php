<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class recetas extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'recetas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_recetas';

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
        'id_usuario',
        'id_categoria_recetas',
        'nombre_receta',
        'descripcion',
        'tiempo_preparacion',
        'numero_porciones',
        'dificultad',
        'foto',
        'estado',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Relación con el modelo Usuario (User)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function cate_recetas()
    {
        return $this->belongsTo(categoria_recetas::class, 'id_categoria_recetas', 'id_categoria_recetas');
    }
}
