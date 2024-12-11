<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_recetas', function (Blueprint $table) {
            $table->id('id_categoria_recetas');  // Definir la columna id como clave primaria
            $table->string('nombre');            // Nombre de la categoría
            $table->string('descripcion');       // Descripción de la categoría
            $table->longText('foto')->nullable(); // Foto de la categoría (base64 o URL, puede ser nulo)
            $table->boolean('estado')->default(true); // Estado de la categoría (activo por defecto)
            $table->timestamps();  // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_recetas');
    }
}
