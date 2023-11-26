<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Alumno;

use App\Models\Maestria;

use App\Models\Secretario;


class DashboardAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $user = auth()->user();
        $alumnos = Alumno::with('maestria')->get();
        // Obtener datos para el gráfico de matriculados por maestría
        $matriculadosPorMaestria = Maestria::withCount('alumnos')->get();

        return view('dashboard.administrador', compact('alumnos', 'matriculadosPorMaestria', 'perPage'));
    }

}
