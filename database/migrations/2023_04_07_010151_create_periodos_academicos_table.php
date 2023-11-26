<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodosAcademicosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('periodos_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('status', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodos_academicos');
    }
};
