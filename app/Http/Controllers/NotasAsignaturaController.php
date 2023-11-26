<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use\App\Models\Asignatura;
use\App\Models\Aula;
use\App\Models\Paralelo;
use\App\Models\Docente;
use\App\Models\Cohorte;
use\App\Models\Alumno;
use Carbon\Carbon;
class NotasAsignaturaController extends Controller
{
    public function show($docenteDni, $asignaturaId, $cohorteId, $aulaId, $paraleloId)
    {
        if (strlen($docenteDni) === 9) {
            $docenteDni = '0' . $docenteDni;
        }
        // Obtén las matrículas de los alumnos en la asignatura, cohorte, aula y paralelo especificados
        $alumnosMatriculados = Alumno::whereHas('matriculas', function ($query) use ($asignaturaId, $cohorteId, $docenteDni) {
            $query->where('asignatura_id', $asignaturaId)
                  ->where('cohorte_id', $cohorteId)
                  ->where('docente_dni', $docenteDni);
        })
        ->with(['matriculas', 'matriculas.asignatura', 'matriculas.cohorte', 'matriculas.docente'])
        ->get();

        $asignatura = Asignatura::find($asignaturaId); // Suponiendo que tienes un modelo Asignatura
        $aula = Aula::find($aulaId); // Suponiendo que tienes un modelo Aula
        $paralelo = Paralelo::find($paraleloId); // Suponiendo que tienes un modelo Paralelo
        $docente = Docente::find($docenteDni); // Suponiendo que tienes un modelo Docente
        $cohorte = Cohorte::find($cohorteId); // Suponiendo que tienes un modelo Cohorte


        // Acceder a los datos de periodo_academico en la cohorte
        $periodo_academico = $cohorte->periodo_academico;

        // Acceder a los datos de periodo_academico en la cohorte
        $cohorte = Cohorte::find($cohorteId);
        $fechaActual = Carbon::now()->locale('es')->isoFormat('LL');

        //$fechaActual = Carbon::now()->locale('es')->isoFormat('LL');

        // Crear una instancia de Dompdf con las opciones y pasar los datos a la vista PDF
        $pdf = Pdf::loadView('record.notas_asignatura', compact('alumnosMatriculados', 
        'asignatura', 
        'fechaActual',
        'aula', 
        'paralelo', 
        'docente', 
        'periodo_academico', 
        'cohorte'));

        $pdf->setPaper('a4', 'landscape')->setWarnings(false);

        // Mostrar el PDF para visualización o descarga
        return $pdf->stream('notas.pdf');
    }

}
