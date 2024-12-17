<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso', function (Blueprint $table) {
            $table->id('id_ingreso'); // Crea la columna id_ingreso como llave primaria
            $table->unsignedBigInteger('id_producto'); // Columna id_producto como FK
            $table->string('tipo_movimiento'); // Columna tipo_movimiento
            $table->float('costo_unitario'); // Columna cantidad
            $table->float('costo_total'); // Columna cantidad
            $table->float('cantidad');  // Columna cantidad
            $table->string('motivo'); // Columna motivo
            $table->unsignedBigInteger('id_usuario'); // Columna id_usuario como FK
            $table->boolean('estado')->default(true); // Columna estado
            $table->timestamps(); // Crea las columnas created_at y updated_at

            // Definición de claves foráneas
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
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
        Schema::dropIfExists('ingreso');
    }
}
