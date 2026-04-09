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
        Schema::table('peticiones', function (Blueprint $table) {
            $table->integer('horas_estimadas')->default(1)->after('practica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peticiones', function (Blueprint $table) {
            $table->dropColumn('horas_estimadas');
        });
    }
};
