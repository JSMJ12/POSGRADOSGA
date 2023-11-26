<?php

namespace App\Http\Controllers;
use App\Models\Alumno;
use App\Models\Secretario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function show($alumno_dni)
    {
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }
        // Obtener el alumno y sus notas
        $alumno = Alumno::findOrFail($alumno_dni);
        $notas = $alumno->notas()->with('asignatura', 'docente')->get();
        
        $seccionId = $alumno->maestria->secciones->first()->id;

        $secretarios = Secretario::where('seccion_id', $seccionId)->get();


        $totalCreditos = $notas->sum(function ($nota) {
            return $nota->asignatura->credito;
        });

        // Obtener la cohorte del alumno
        $cohorte = $alumno->maestria->cohorte->first();
        
        preg_match('/Cohorte (\w+)/', $cohorte->nombre, $matches);
        $numeroRomano = $matches[1] ?? '';

        // Acceder a los datos de periodo_academico en la cohorte
        $periodo_academico = $cohorte->periodo_academico;

        $fechaActual = Carbon::now()->locale('es')->isoFormat('LL');

        // Crear una instancia de Dompdf con las opciones
        $pdf = Pdf::loadView('record.show', compact('secretarios','alumno', 'notas', 'periodo_academico', 'cohorte', 'totalCreditos', 'numeroRomano', 'fechaActual'));

        // Mostrar el PDF para visualización o descarga
        return $pdf->stream($alumno->apellidop . $alumno->nombre1 . '_notas.pdf');
    }

    /*public function show($alumno_dni)
    {
        $alumno = Alumno::findOrFail($alumno_dni);
        $notas = $alumno->notas()->with('asignatura', 'docente')->get();
        $data = [
            'alumno' => $alumno,
            'notas' => $notas
        ];

        // Renderiza la vista y devuelve la respuesta
        return view('record.show', $data);
    }*/

}
