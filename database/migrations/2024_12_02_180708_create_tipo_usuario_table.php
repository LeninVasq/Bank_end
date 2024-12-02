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
            $table->unsignedBigInteger('id_usuario'); // Columna para clave foránea a `users`
            $table->string('tipo'); // Tipo de usuario
            $table->boolean('estado')->default(true); // Estado del tipo de usuario (activo o inactivo)
            $table->timestamps(); // Timestamps para created_at y updated_at

            // Definir la clave foránea
            $table->foreign('id_usuario')
                  ->references('id_usuario') // Apunta a `id_usuario` en la tabla `users`
                  ->on('users') // En la tabla `users`
                  ->onDelete('cascade'); // Si se elimina un usuario, se elimina el tipo de usuario asociado
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
