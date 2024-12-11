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
            $table->unsignedBigInteger('id_usuario'); // Columna id_usuario como FK
            $table->unsignedBigInteger('id_categoria_recetas'); // Columna id_usuario como FK
            $table->string('nombre_receta'); // Columna nombre_receta
            $table->string('descripcion'); // Columna descripcion
            $table->integer('tiempo_preparacion'); // Columna tiempo_preparacion (en minutos o unidades de tiempo)
            $table->integer('numero_porciones'); // Columna numero_porciones
            $table->string('dificultad'); // Columna dificultad (por ejemplo, "Fácil", "Media", "Difícil")
            $table->longText('foto')->nullable();
            $table->boolean('estado')->default(true); // Columna estado (activo o inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at

            // Definición de claves foráneas
            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('id_categoria_recetas')->references('id_categoria_recetas')->on('categoria_recetas')->onDelete('cascade');
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
