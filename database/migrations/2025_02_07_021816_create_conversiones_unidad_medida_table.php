<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionesUnidadMedidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversiones_unidad_medida', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_unidad_origen');
            $table->unsignedBigInteger('id_unidad_destino');
            $table->double('factor');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_unidad_origen')
                  ->references('id_unidad_medida')
                  ->on('unidad_medida')
                  ->onDelete('cascade');

            $table->foreign('id_unidad_destino')
                  ->references('id_unidad_medida')
                  ->on('unidad_medida')
                  ->onDelete('cascade');

            // Índices únicos para evitar duplicados
            $table->unique(['id_unidad_origen', 'id_unidad_destino'], 'unica_conversion_ud');});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversiones_unidad_medida');
    }
}
