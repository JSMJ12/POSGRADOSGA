<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;
use App\Models\Maestria;
use App\Models\Nota;
use App\Models\AsignaturaDocente;
use App\Models\Matricula;

class Asignatura extends Model
{
    
    protected $fillable = [
        'nombre',
        'codigo_asignatura',
        'credito',
        'itinerario',
        'maestria_id',
    ];

    public function maestria()
    {
        return $this->belongsTo(Maestria::class);
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'asignatura_docente');
    }
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
    public function cohortes()
    {
        return $this->belongsToMany(Cohorte::class, 'cohorte_docente', 'asignatura_id', 'cohort_id');
    }

    public function docentes2()
    {
        return $this->belongsToMany(Docente::class, 'cohorte_docente', 'asignatura_id', 'docente_dni');
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
