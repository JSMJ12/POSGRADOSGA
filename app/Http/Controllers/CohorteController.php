<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cohorte;
use App\Models\Maestria;
use App\Models\Secretario;
use App\Models\PeriodoAcademico;
use App\Models\Aula;

class CohorteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $cohortes = Cohorte::with(['maestria', 'periodo_academico', 'aula'])->get();

        return view('cohortes.index', compact('cohortes', 'perPage'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('Secretario')) {
            $secretario = Secretario::where('nombre1', $user->name)
                ->where('apellidop', $user->apellido)
                ->where('email', $user->email)
                ->firstOrFail();
            //
            $maestriasIds = $secretario->seccion->maestrias->pluck('id');
            $maestrias = Maestria::whereIn('id', $maestriasIds)
                ->where('status', 'ACTIVO')
                ->get();
        } else {
            $maestrias = Maestria::where('status', 'ACTIVO')->get();
        }
        $periodos_academicos = PeriodoAcademico::all();
        $aulas = Aula::all();

        return view('cohortes.create', compact('maestrias', 'periodos_academicos', 'aulas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'maestria_id' => 'required|exists:maestrias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'aula_id' => 'required|exists:aulas,id',
            'aforo' => 'required|integer',
            'modalidad' => 'required|in:presencial,hibrida,virtual',
        ]);

        Cohorte::create([
            'nombre' => $request->input('nombre'),
            'maestria_id' => $request->input('maestria_id'),
            'periodo_academico_id' => $request->input('periodo_academico_id'),
            'aula_id' => $request->input('aula_id'),
            'aforo' => $request->input('aforo'),
            'modalidad' => $request->input('modalidad'),
        ]);

        return redirect()->route('cohortes.index')->with('success', 'La cohorte ha sido creada exitosamente.');
    }

    public function edit(Cohorte $cohorte)
    {
        $maestrias = Maestria::all();
        $periodos_academicos = all();
        $aulas = Aula::all();

        return view('cohortes.edit', compact('cohorte', 'maestrias', 'periodos_academicos', 'aulas'));
    }

    public function update(Request $request, Cohorte $cohorte)
    {
        $request->validate([
            'nombre' => 'required|string',
            'maestria_id' => 'required|exists:maestrias,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'aula_id' => 'required|exists:aulas,id',
            'aforo' => 'required|integer',
            'modalidad' => 'required|in:presencial,hibrida,virtual',
        ]);

        $cohorte->update([
            'nombre' => $request->input('nombre'),
            'maestria_id' => $request->input('maestria_id'),
            'periodo_academico_id' => $request->input('periodo_academico_id'),
            'aula_id' => $request->input('aula_id'),
            'aforo' => $request->input('aforo'),
            'modalidad' => $request->input('modalidad'),
        ]);

        return redirect()->route('cohortes.index')->with('success', 'La cohorte ha sido actualizada exitosamente.');
    }
    public function destroy(Cohorte $cohorte)
    {
        try {
            $cohorte->delete();
            return redirect()->route('cohortes.index')->with('success', 'El cohorte ha sido eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('cohortes.index')->with('error', 'Error al eliminar el cohorte: ' . $e->getMessage());
        }

    }
}
