<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu'); // Crea la columna id_menu como llave primaria
            $table->string('nombre'); // Columna nombre
            $table->decimal('precio', 10, 2); // Columna precio con formato decimal
            $table->integer('cantidad_platos'); // Columna cantidad_platos
            $table->string('descripcion'); // Columna descripcion
            $table->longText('img'); // Columna img para la imagen del menú
            $table->boolean('estado'); // Columna estado (activo o inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
