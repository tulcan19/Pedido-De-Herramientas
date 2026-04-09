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
        Schema::table('herramientas', function (Blueprint $table) {
            $table->boolean('es_alto_valor')->default(false)->after('ubicacion');
            $table->json('accesorios')->nullable()->after('es_alto_valor');
        });

        Schema::table('prestamos', function (Blueprint $table) {
            $table->string('foto_devolucion')->nullable()->after('fecha_devolucion_real');
            $table->json('checklist_accesorios')->nullable()->after('foto_devolucion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('herramientas', function (Blueprint $table) {
            $table->dropColumn(['es_alto_valor', 'accesorios']);
        });

        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropColumn(['foto_devolucion', 'checklist_accesorios']);
        });
    }
};
