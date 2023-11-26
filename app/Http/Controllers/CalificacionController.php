<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Matricula;
use App\Models\Docente;
class CalificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($docente_dni, $asignatura_id, $cohorte_id)
    {
        if (strlen($docente_dni) === 9) {
            $docente_dni = '0' . $docente_dni;
        }
        $matriculas = Matricula::where('docente_dni', $docente_dni)
                                ->where('asignatura_id', $asignatura_id)
                                ->where('cohorte_id', $cohorte_id)
                                ->get();
        $alumnos = collect([]);
        foreach ($matriculas as $matricula) {
            $alumnos->push($matricula->alumno);
        }
        return view('calificaciones.create', compact('alumnos', 'docente_dni', 'asignatura_id', 'cohorte_id'));
    }
    public function store(Request $request)
    {
        $docenteDni = $request->input('docente_dni');
        if (strlen($docenteDni) === 9) {
            $docenteDni = '0' . $docenteDni;
        }
        $asignaturaId = $request->input('asignatura_id');
        $cohorteId = $request->input('cohorte_id');
        $alumnoDnis = $request->input('alumno_dni');
        foreach ($alumnoDnis as &$alumno_dni) {
            if (strlen($alumno_dni) === 9) {
                $alumno_dni = '0' . $alumno_dni;
            }
        }
        $notasActividades = $request->input('nota_actividades');
        $notasPracticas = $request->input('nota_practicas');
        $notasAutonomo = $request->input('nota_autonomo');
        $examenesFinales = $request->input('examen_final');
        $recuperaciones = $request->input('recuperacion');
        $totales = $request->input('total');
        
        foreach ($alumnoDnis as $alumnoId) {
            $calificacion = Nota::updateOrCreate(
                ['docente_dni' => $docenteDni, 'alumno_dni' => $alumnoId, 'asignatura_id' => $asignaturaId, 'cohorte_id' => $cohorteId],
                [
                    'docente_dni' => $docenteDni,
                    'alumno_dni' => $alumnoId,
                    'nota_actividades' => $notasActividades[$alumnoId] ?? null,
                    'nota_practicas' => $notasPracticas[$alumnoId] ?? null,
                    'nota_autonomo' => $notasAutonomo[$alumnoId] ?? null,
                    'examen_final' => $examenesFinales[$alumnoId] ?? null,
                    'recuperacion' => $recuperaciones[$alumnoId] ?? null,
                    'total' => $totales[$alumnoId] ?? null,
                    'asignatura_id' => $asignaturaId,
                    'cohorte_id' => $cohorteId,
                ]
            );
        }

        $docenteNombre = auth()->user()->name;
        $docenteApellido = auth()->user()->apellido;
        $docenteEmail = auth()->user()->email;
        $docente = Docente::where('nombre1', $docenteNombre)
                        ->where('apellidop', $docenteApellido)
                        ->where('email', $docenteEmail)
                        ->first();
        // 
        $docente_dni = $docente->dni;
        if (strlen($docente_dni) === 9) {
            $docente_dni = '0' . $docente_dni;
        }
        $asignaturas = $docente->asignaturas;

        // Obtener los alumnos matriculados en las asignaturas del docente
        $alumnos = collect();
        foreach ($asignaturas as $asignatura) {
            $matriculas = $asignatura->matriculas;
            foreach ($matriculas as $matricula) {
                $alumno = $matricula->alumno;
                $alumnos->push($alumno);
            }
        }
                    
        return view('dashboard.docente', compact('docente', 'asignaturas', 'alumnos', 'docente_dni'));
    }
    public function edit($id)
    {
        $nota = Nota::find($id);

        return view('calificaciones.edit', compact('nota'));
    }
    public function update(Request $request, $id)
    {
        $nota = Nota::findOrFail($id);
        $nota->nota_actividades = $request->nota_actividades;
        $nota->nota_practicas = $request->nota_practicas;
        $nota->nota_autonomo = $request->nota_autonomo;
        $nota->examen_final = $request->examen_final;
        $nota->recuperacion = $request->recuperacion;
        $nota->total = $request->total;
        $nota->save();

        return redirect()->route('calificaciones.show1', [$nota->alumno_dni, $nota->docente_dni, $nota->asignatura_id, $nota->cohorte_id])->with('success', 'La nota ha sido actualizada exitosamente.');
    }

    public function show($alumno_dni, $docente_dni, $asignatura_id, $cohorte_id)
    {
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }
        
        if (strlen($docente_dni) === 9) {
            $docente_dni = '0' . $docente_dni;
        }
        $notas = Nota::where('cohorte_id', $cohorte_id)
                    ->where('asignatura_id', $asignatura_id)
                    ->where('docente_dni', $docente_dni)
                    ->where('alumno_dni', $alumno_dni)
                    ->get();

        return view('calificaciones.show', compact('notas'));
    }
}
