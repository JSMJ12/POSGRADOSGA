<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaestriaIdToAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->foreignId('maestria_id')->constrained('maestrias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
};
