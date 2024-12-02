<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas_item', function (Blueprint $table) {
            $table->id('id_reserva_item'); // Crea la columna id_reserva_item como llave primaria
            $table->unsignedBigInteger('id_menu'); // Columna id_menu como FK
            $table->integer('cantidad'); // Columna cantidad
            $table->boolean('estado'); // Columna estado (activo o inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at
            $table->unsignedBigInteger('id_reservas'); // Columna id_reserva_item como FK


            // Definición de claves foráneas
            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
            $table->foreign('id_reservas')->references('id_reservas')->on('reservas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas_item');
    }
}
