<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id('id_recetas'); // Crea la columna id_recetas como llave primaria
            $table->string('nombre_receta'); // Columna nombre_receta
            $table->string('descripcion'); // Columna descripcion
            $table->integer('tiempo_preparacion'); // Columna tiempo_preparacion (en minutos o unidades de tiempo)
            $table->integer('numero_porciones'); // Columna numero_porciones
            $table->string('dificultad'); // Columna dificultad (por ejemplo, "Fácil", "Media", "Difícil")
            $table->unsignedBigInteger('id_recetas_producto'); // Columna id_recetas_producto como FK
            $table->date('fecha_creacion'); // Columna fecha_creacion
            $table->string('foto'); // Columna foto
            $table->boolean('estado'); // Columna estado (activo o inactivo)
            $table->unsignedBigInteger('id_usuario'); // Columna id_usuario como FK
            $table->timestamps(); // Crea las columnas created_at y updated_at

            // Definición de claves foráneas
            $table->foreign('id_recetas_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recetas');
    }
}
