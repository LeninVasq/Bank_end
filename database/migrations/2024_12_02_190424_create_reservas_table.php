<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reservas'); // Crea la columna id_reservas como llave primaria
            $table->unsignedBigInteger('id_usuario'); // Columna id_usuario como FK
            $table->dateTime('fecha_entrega')->nullable(); // Columna fecha_entrega
            $table->boolean('estado')->default(true); // Columna estado (activo o inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at

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
        Schema::dropIfExists('reservas');
    }
}
