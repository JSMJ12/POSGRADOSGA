<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maestria;
use App\Models\Asignatura;
use App\Models\Docente;
use App\Models\Cohorte;
use App\Models\CohorteDocente;

class CohorteDocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($docente_dni, $asignatura_id = null)
    {
        $docente = Docente::where('dni', $docente_dni)->firstOrFail();
        $asignaturas = $docente->asignaturas;
        

        // Obtén los IDs de los cohortes ya asignados al docente
        $cohortesAsignados = $docente->cohortes->pluck('id')->all();

        if ($asignatura_id) {
            $asignatura = Asignatura::findOrFail($asignatura_id);
            $maestria = Maestria::findOrFail($asignatura->maestria_id);
            $cohortes = $maestria->cohorte->whereNotIn('id', $cohortesAsignados);

            $maestriaCohortes = [
                [
                    'asignatura' => $asignatura,
                    'maestria' => $maestria,
                    'cohortes' => $cohortes
                ]
            ];
        } else {
            $maestriaCohortes = [];

            foreach ($asignaturas as $asignatura) {
                $maestria = Maestria::findOrFail($asignatura->maestria_id);
                $cohortes = $maestria->cohorte->whereNotIn('id', $cohortesAsignados);
                $maestriaCohortes[] = [
                    'asignatura' => $asignatura,
                    'maestria' => $maestria,
                    'cohortes' => $cohortes
                ];
            }
        }

        return view('cohortes_docentes.create', compact('docente', 'asignaturas', 'maestriaCohortes', 'asignatura_id'));
    }
    public function store(Request $request)
    {
        $cohorteIds = $request->input('cohorte_id', []);
        $docenteDni = $request->input('docente_dni');
        if (!str_starts_with($docenteDni, '0')) {
            $docenteDni = '0' . $docenteDni;
        }        
        $asignaturaId = $request->input('asignatura_id');

        foreach ($cohorteIds as $cohorteId) {
            $asignacion = new CohorteDocente;
            $asignacion->cohort_id = $cohorteId;
            $asignacion->docente_dni = $docenteDni;
            $asignacion->asignatura_id = $asignaturaId;
            $asignacion->save();
        }

        return redirect()->route('docentes.index');
    }
}
