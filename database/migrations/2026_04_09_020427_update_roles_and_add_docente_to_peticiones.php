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
        // Actualizar el enum de roles en la tabla usuarios
        // Nota: En MySQL/PostgreSQL alteramos la columna. En SQLite es más complejo pero Laravel 10/11 lo maneja mejor.
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('rol')->default('estudiante')->change(); // Cambiamos a string temporalmente para aceptar cualquier valor o expandir el enum
        });

        Schema::table('peticiones', function (Blueprint $table) {
            $table->unsignedBigInteger('docente_id')->nullable()->after('usuario_id');
            $table->foreign('docente_id')->references('id')->on('usuarios')->onDelete('set null');
            
            // Opcional: Podríamos eliminar la columna 'docente' (string) pero la dejaremos por ahora por si hay datos previos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peticiones', function (Blueprint $table) {
            $table->dropForeign(['docente_id']);
            $table->dropColumn('docente_id');
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'estudiante'])->default('estudiante')->change();
        });
    }
};
