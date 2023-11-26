<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secretarios', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['seccion_id']);
            
            // Eliminar la columna maestria_id
            $table->dropColumn('seccion_id');
        });
        Schema::dropIfExists('secciones');
    }
};
