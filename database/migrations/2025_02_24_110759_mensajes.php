<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id('id_mensajes'); // Crea la columna id_unidad_medida como llave primaria
            $table->string('Mensaje'); // Columna nombre_unidad
            $table->unsignedBigInteger('id_usuario'); // Columna id_producto como FK
            $table->boolean('estado')->default(true); // Columna estado (activo o inactivo)
            $table->timestamps(); // Crea las columnas created_at y updated_at

            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
