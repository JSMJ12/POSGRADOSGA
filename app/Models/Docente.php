<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asignatura;
use App\Models\AsignaturaDocente;
use App\Models\CohorteDocente;
use App\Models\Cohorte;
use App\Models\Matricula;

class Docente extends Model
{
    protected $primaryKey = 'dni';
    protected $keyType = 'string';

    protected $fillable = [
        'nombre',
        'apellido',
        'contra',
        'sexo',
        'status',
        'dni',
        'tipo',
        'docen_foto',
    ];

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_docente');
    }
    public function asignatura_docentes()
    {
        return $this->hasMany(AsignaturaDocente::class);
    }
    public function cohortes()
    {
        return $this->belongsToMany(Cohorte::class, 'cohorte_docente', 'docente_dni', 'cohort_id');
    }
    public function cohorte_docente()
    {
        return $this->hasMany(CohorteDocente::class);
    }
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
    public function cohorteDocente()
    {
        return $this->hasMany(CohorteDocente::class, 'docente_dni');
    }
}
