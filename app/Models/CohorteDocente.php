<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\Cohorte;
class CohorteDocente extends Model
{
    
    protected $table = 'cohorte_docente';
    protected $fillable = ['cohort_id', 'docente_dni', 'asignatura_id'];
    
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
    public function cohorte()
    {
        return $this->belongsTo(Cohorte::class);
    }
}
