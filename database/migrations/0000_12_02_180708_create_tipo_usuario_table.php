<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_usuario', function (Blueprint $table) {
            $table->id('id_tipo_usuario'); // ID de tipo de usuario como clave primaria
            $table->string('tipo'); // Tipo de usuario
            $table->boolean('estado')->default(true); // Estado del tipo de usuario (activo o inactivo)
            $table->timestamps(); 

          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_usuario');
    }
}
