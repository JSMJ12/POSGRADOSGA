<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaestriasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maestrias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('status', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('alumnos', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['maestria_id']);
            
            // Eliminar la columna maestria_id
            $table->dropColumn('maestria_id');
        });

        // Eliminar la tabla maestrias
        Schema::dropIfExists('maestrias');
    }
};
