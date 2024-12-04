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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_usuario'); 
            $table->unsignedBigInteger('id_tipo_usuario'); // Columna para clave foránea a `users`
            $table->string('correo')->unique(); // Correo electrónico (único)
            $table->boolean('correo_verificado')->default(false); // Estado del usuario (activo o inactivo)
            $table->string('clave'); // Clave de acceso
            $table->string('token')->nullable(); // Token, puede ser nulo
            $table->longText('img')->default("sjdbkjsbdls"); // Imagen del usuario, puede ser nula
            $table->boolean('estado')->default(true); // Estado del usuario (activo o inactivo)
            $table->timestamps(); // Timestamps para created_at y updated_at


            $table->foreign('id_tipo_usuario')
                  ->references('id_tipo_usuario') // Apunta a `id_usuario` en la tabla `users`
                  ->on('tipo_usuario') // En la tabla `users`
                  ->onDelete('cascade'); 
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
