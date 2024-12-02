<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaProTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_pro', function (Blueprint $table) {
            $table->id('id_categoria'); // Columna id_categoria como clave primaria
            $table->string('nombre_categoria'); // Nombre de la categoría
            $table->string('descripcion'); // Descripción de la categoría
            $table->boolean('estado')->default(true); // Estado de la categoría (activo o inactivo)
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_pro');
    }
}
