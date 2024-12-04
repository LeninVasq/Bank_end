<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tipo_usuario extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'tipo_usuario';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_tipo_usuario';

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
        'tipo',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];
}
