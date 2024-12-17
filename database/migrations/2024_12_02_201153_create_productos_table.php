<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto'); // Crea la columna id_producto como llave primaria
            $table->string('nombre'); // Columna nombre
            $table->string('descripcion'); // Columna descripcion
            $table->float('stock')->default(0); // Columna descripcion
            $table->unsignedBigInteger('id_unidad_medida'); // Columna id_unidad_medida como FK
            $table->unsignedBigInteger('id_usuario'); // Columna id_usuario como FK
            $table->unsignedBigInteger('id_categoria_pro'); // Columna id_categoria como FK
            $table->longText('foto'); // Columna foto de tipo longtext
            $table->boolean('estado')->default(true); // Columna estado
            $table->timestamps(); // Crea las columnas created_at y updated_at

            // Definición de claves foráneas
            $table->foreign('id_unidad_medida')->references('id_unidad_medida')->on('unidad_medida')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('id_categoria_pro')->references('id_categoria_pro')->on('categoria_pro')->onDelete('cascade');
        });

        DB::statement("
            CREATE VIEW categoria_count_productos AS
            SELECT c.*, COUNT(p.id_categoria_pro) AS cantidad_productos
            FROM categoria_pro c
            LEFT JOIN productos p ON c.id_categoria_pro = p.id_categoria_pro
            GROUP BY c.id_categoria_pro, c.nombre_categoria, c.descripcion, c.estado, c.created_at, c.updated_at, c.foto
            ORDER BY cantidad_productos DESC
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS categoria_count_productos");

        Schema::dropIfExists('productos');
    }
}
