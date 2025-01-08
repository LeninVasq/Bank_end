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
        'precio',
        'cantidad_platos',
        'descripcion', 
        'img',
        'estado',
        'id_categoria',
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
        'estado' => 'boolean', 
    ];

    public function categoria()
    {
        return $this->belongsTo(categoria_menu::class, 'id_categoria');
    }

}
