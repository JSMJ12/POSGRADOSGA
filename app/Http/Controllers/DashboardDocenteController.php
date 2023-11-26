<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Docente;
use App\Models\CohorteDocente;

class DashboardDocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $user = auth()->user();
        $docente = Docente::where('email', $user->email)->firstOrFail();
        $asignaturas = $docente->asignaturas;

        return view('dashboard.docente', compact('docente', 'asignaturas', 'perPage'));
    }

}
