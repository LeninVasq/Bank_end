<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mensajes extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla si no sigue la convención de pluralización
    protected $table = 'mensajes';

/**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_mensajes';

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
        'id_mensajes',
        'Mensaje',
        'id_usuario',
        'estado',
    ];

    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    protected $casts = [
        'estado' => 'boolean'
    ];
}
