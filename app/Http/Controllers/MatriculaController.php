<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Matricula;
use App\Models\Cohorte;
use App\Models\Maestria;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($alumno_dni, $cohorte_id = null)
    {
        // Verificar si el alumno_dni tiene 9 dígitos y agregar un cero al inicio si es necesario
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }

        $alumno = Alumno::where('dni', $alumno_dni)->firstOrFail();
        $maestria = Maestria::findOrFail($alumno->maestria_id);
        $cohortes = $maestria->cohorte;
        $cohorte = $cohorte_id ? Cohorte::findOrFail($cohorte_id) : null;
        
        // Verificar si el alumno ya está matriculado en alguna asignatura de este cohorte
        $estaMatriculado = $this->verificarMatriculacion($alumno, $cohorte);

        if ($estaMatriculado) {
            return redirect()->back()->with('error', 'El alumno ya está matriculado en este cohorte.');
        }
        return view('matriculas.create', compact('alumno', 'cohortes', 'cohorte'));
    }


    private function verificarMatriculacion($alumno, $cohorte)
    {
        $dni= $alumno->dni;
        if (strlen($dni) === 9) {
            $dni = '0' . $dni;
        }
        // Verificar si el alumno está matriculado en alguna asignatura de este cohorte
        return $alumno->matriculas()->where('alumno_dni', $dni)->exists();
    }

    public function store(Request $request)
    {

        $alumno_dni = $request->input('alumno_dni');
        if (strlen($alumno_dni) === 9) {
            $alumno_dni = '0' . $alumno_dni;
        }
        $cohorte_id = $request->input('cohorte_id');
        $asignatura_ids = $request->input('asignatura_ids');
        $docente_dnis = $request->input('docente_dnis');
        foreach ($docente_dnis as &$docente_dni) {
            if (strlen($docente_dni) === 9) {
                $docente_dni = '0' . $docente_dni;
            }
        }
        
        $cohorte = Cohorte::findOrFail($request->input('cohorte_id'));

        // verificar que el aforo del cohorte sea mayor a cero
        if ($cohorte->aforo > 0) {
            try {
                // Iniciar una transacción para garantizar la integridad de los datos
                DB::beginTransaction();

                foreach ($asignatura_ids as $key => $asignatura_id) {
                    // Crear la matrícula
                    Matricula::create([
                        'alumno_dni' => $alumno_dni,
                        'asignatura_id' => $asignatura_id,
                        'cohorte_id' => $cohorte_id,
                        'docente_dni' => $docente_dnis[$key],
                    ]);
                }

                // Restar 1 al aforo del cohorte
                $cohorte->aforo = $cohorte->aforo - 1;
                $cohorte->save();

                // Actualizar el aforo de las asignaturas en el cohorte
                $cohorte->asignaturas()->sync($asignatura_ids, false);

                // Commit de la transacción
                DB::commit();

                return redirect()->route('alumnos.index')->with('success', 'Matrícula exitosa.');
            } catch (\Exception $e) {
                // Si hay algún error, hacer rollback de la transacción
                DB::rollback();
                return redirect()->back()->with('error', 'Error en la matriculación: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'No hay cupo disponible en este cohorte.');
        }
    }
}
