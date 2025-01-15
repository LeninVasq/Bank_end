<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->timestamps(); // Crea las columnas created_at y updated_at
            $table->foreign('id_categoria')->references('id_categoria_menu')->on('categoria_menu')->onDelete('cascade');
        });

        DB::statement("

CREATE PROCEDURE app_menu(
    IN id_categoria_param INT
)
BEGIN
    SELECT
        `menu`.`id_menu`         AS `id_menu`,
        `menu`.`nombre`          AS `nombre`,
        `menu`.`precio`          AS `precio`,
        `menu`.`cantidad_platos` AS `cantidad_platos`
    FROM `menu`
    WHERE `id_categoria` = id_categoria_param AND cantidad_platos > 0;
END 

        
        ");
        DB::statement("


CREATE PROCEDURE app_menu_img(
    IN id_categoria_param INT
)
BEGIN
    SELECT
        `menu`.`id_menu` AS `id_menu`,
        `menu`.`img`     AS `img`
    FROM `menu`
    WHERE `id_categoria` = id_categoria_param AND cantidad_platos > 0;
END 
        ");
        DB::statement("
        CREATE VIEW app_categoria_menu AS
        SELECT id_categoria_menu,nombre,foto FROM categoria_menu
        ");
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
