<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cohorte;
use App\Models\Alumno;
use App\Models\Seccion;
use App\Models\Asignatura;
use App\Models\Postulante;

class Maestria extends Model
{
    
    protected $table = 'maestrias';

    protected $fillable = [
        'nombre', 'status', 'precio_total', 'fecha_inicio', 'fecha_fin', 'coordinador'
    ];
    public function cohorte()
    {
        return $this->hasMany(Cohorte::class);
    }
    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }
    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'maestria_seccion', 'maestria_id', 'seccion_id');
    }
    public function postulantes()
    {
        return $this->belongsToMany(Postulante::class);
    }
}
