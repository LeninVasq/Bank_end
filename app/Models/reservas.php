<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservas extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reservas';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_usuario',
        'fecha_entrega',
        'estado',
    ];
    public $timestamps = true;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
