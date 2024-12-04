<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class unidad_medida extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'unidad_medida';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_unidad_medida';

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
        'nombre_unidad',
        'estado'
    ];
    protected $casts = [
        'estado' => 'boolean'
    ];
    
}
