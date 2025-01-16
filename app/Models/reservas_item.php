<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservas_item extends Model
{
    use HasFactory;

    protected $table = 'reservas_item';
    protected $primaryKey = 'id_reserva_item';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'id_menu',
        'cantidad',
        'precio',
        'estado',
        'id_reservas',
    ];
    public $timestamps = true;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    public function reserva()
    {
        return $this->belongsTo(reservas::class, 'id_reservas');
    }
}
