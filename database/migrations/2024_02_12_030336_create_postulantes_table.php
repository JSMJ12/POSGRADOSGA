<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulantes', function (Blueprint $table) {
            $table->string('dni')->primary();
            $table->string('apellidop');
            $table->string('apellidom');
            $table->string('nombre1');
            $table->string('nombre2');
            $table->string('correo_electronico')->nullable();
            $table->string('celular')->nullable();
            $table->string('titulo_profesional')->nullable();
            $table->string('universidad_titulo')->nullable();
            $table->enum('sexo', ['HOMBRE', 'MUJER']);
            $table->date('fecha_nacimiento');
            $table->string('nacionalidad')->nullable();
            $table->enum('discapacidad', ['Si', 'No']);
            $table->float('porcentaje_discapacidad')->nullable();
            $table->string('codigo_conadis')->nullable();
            $table->string('provincia')->nullable();
            $table->string('etnia')->nullable();
            $table->string('nacionalidad_indigena')->nullable();
            $table->string('canton')->nullable();
            $table->string('direccion')->nullable();
            $table->string('tipo_colegio')->nullable();
            $table->integer('cantidad_miembros_hogar')->nullable();
            $table->string('ingreso_total_hogar')->nullable();
            $table->string('nivel_formacion_padre')->nullable();
            $table->string('nivel_formacion_madre')->nullable();
            $table->string('origen_recursos_estudios')->nullable();
            $table->string('imagen')->nullable(); 
            $table->string('pdf_cedula'); 
            $table->string('pdf_papelvotacion'); 
            $table->string('pdf_titulouniversidad'); 
            $table->string('pdf_conadis')->nullable(); 
            $table->foreignId('maestria_id')->constrained('maestrias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postulantes');
    }
}
