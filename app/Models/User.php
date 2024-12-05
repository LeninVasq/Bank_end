<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    protected $table = 'users';

    
    protected $primaryKey = 'id_usuario';

   
    public $timestamps = true;

  
    protected $fillable = [
        'id_tipo_usuario',
        'correo',
        'correo_verificado',
        'clave',
        'token',
        'img',
        'estado'
    ];

  
    protected $hidden = [
        'clave',
        'token'
    ];

   
    protected $casts = [
        'estado' => 'boolean'
    ];

    protected function casts(): array
    {
        return [
            'clave' => 'hashed',
        ];
    }
    public function getAuthPassword()
    {
        return $this->clave; 
    }

    public function getAuthIdentifierName()
{
    return 'correo';
}


    public function tipo_usuario()
    {
        return $this->belongsTo(tipo_usuario::class, 'id_tipo_usuario');
    }
}
