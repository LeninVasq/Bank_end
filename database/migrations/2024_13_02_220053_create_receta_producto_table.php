<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetaProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receta_producto', function (Blueprint $table) {
            $table->id('id_recetas_producto'); // Crea la columna id_recetas_producto como llave primaria
            $table->unsignedBigInteger('id_producto'); // Columna id_producto como FK
            $table->unsignedBigInteger('id_receta'); // Columna id_receta como FK
            $table->decimal('cantidad', 10, 2); // Cambiado a decimal con 2 decimales
            $table->string('nombre_unidad')->nullable(); // Columna nombre unidad de medida en receta
            $table->boolean('estado')->default(true); // Columna estado (activo o inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at
            // Definición de claves foráneas
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
            $table->foreign('id_receta')->references('id_recetas')->on('recetas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receta_producto');
    }
}
