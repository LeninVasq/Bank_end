<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    
    /**
     * @var string
     */
    protected $table = 'menu'; 
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_menu'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'precio',
        'cantidad_platos',
        'descripcion',
        'img',
        'estado',
    ];


    protected $casts = [
        'estado' => 'boolean', 
    ];

}
