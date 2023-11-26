<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        // Obtener todos los docentes
        $docentes = Docente::all();
        return view('docentes.index', compact('docentes', 'perPage'));
    }

    
    public function create()
    {
        return view('docentes.create');
    }
    
    public function store(Request $request)
    {

        $docente = new Docente;
        $docente->nombre1 = $request->input('nombre1');
        $docente->nombre2 = $request->input('nombre2');
        $docente->apellidop = $request->input('apellidop');
        $docente->apellidom = $request->input('apellidom');
        $docente->contra = bcrypt($request->input('dni')); // Encriptar la contraseña
        $docente->sexo = $request->input('sexo');
        $docente->dni = $request->input('dni');
        $docente->tipo = $request->input('tipo');
        $docente->email = $request->input('email');
        $request->validate([
            'docen_foto' => 'nullable|image|max:2048', //máximo tamaño 2MB
        ]);
        if ($request->hasFile('docen_foto')) {
            $image = $request->file('docen_foto')->store('public/imagenes_usuarios');
            $docente->image = url(str_replace('public/', 'storage/', $image));
        } else {
            $docente->image = 'https://as1.ftcdn.net/v2/jpg/05/33/06/98/1000_F_533069872_mryYSuJSR3floH4hxBUkRxeXTAqYOS0i.jpg';
        }
        //Almacenar la imagen
        $docente->save();
        
        $usuario = new User;
        $usuario->name = $request->input('nombre1');
        $usuario->apellido = $request->input('apellidop');
        $usuario->sexo = $request->input('sexo');
        $usuario->password = bcrypt($request->input('dni'));
        $usuario->status = $request->input('estatus', 'ACTIVO');
        $usuario->email = $request->input('email');
        $usuario->image = $docente->image;
        $docenteRole = Role::findById(2);
        $usuario->assignRole($docenteRole);
        $usuario->save();
        
        

        return redirect()->route('docentes.index')->with('success', 'Usuario creado exitosamente.');
    }
    
    public function edit($dni)
    {
        $docente = Docente::where('dni', $dni)->first();
        return view('docentes.edit', compact('docente'));
    }
    
    public function update(Request $request, Docente $docente)
    {
        $docente->nombre1 = $request->input('nombre1');
        $docente->apellidop = $request->input('apellidop');
        $docente->tipo = $request->input('tipo');
        $docente->save();
    
        return redirect()->route('docentes.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    
}