<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Docente;
use App\Models\Alumno;
use App\Models\Secretario;
use App\Models\User;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function actualizarImagen($modelo, $campoImagen, $imagenPath)
    {
        if (request()->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            Storage::delete(str_replace('/storage/', 'public/', $modelo->$campoImagen));

            // Guardar la nueva imagen
            $image = request()->file('image')->store($imagenPath);
            $modelo->$campoImagen = str_replace('public/', '/storage/', $image);
        }
    }

    public function actualizar_p(Request $request)
    {
        $usuario = Auth::user();
        $roles = $usuario->roles()->pluck('name');
        $rol = lcfirst($roles[0]);

        // Actualizar la imagen del usuario
        $this->actualizarImagen($usuario, 'image', 'public/imagenes_usuarios');

        // Verificar si se ha proporcionado una nueva contraseña
        if ($request->has('cambiar-contrasena') && $request->input('cambiar-contrasena') == true) {
            $this->validate($request, [
                'password_actual' => 'required',
                'password_nueva' => 'required|min:8|different:password_actual|confirmed',
            ]);

            if (Hash::check($request->input('password_actual'), $usuario->password)) {
                // La contraseña actual es correcta
                $usuario->password = Hash::make($request->input('password_nueva'));
            } else {
                // La contraseña actual es incorrecta
                return redirect()->back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta']);
            }
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        // Actualizar el perfil según el rol
        switch ($rol) {
            case 'docente':
                $docente = Docente::where('nombre1', $usuario->name)
                    ->where('apellidop', $usuario->apellido)
                    ->where('email', $usuario->email)
                    ->first();
                if ($docente) {
                    $this->actualizarImagen($docente, 'image', 'public/imagenes_docentes');
                    $docente->save();
                }
                break;
            case 'alumno':
                $alumno = Alumno::where('nombre1', $usuario->name)
                    ->where('apellidop', $usuario->apellido)
                    ->where('email_institucional', $usuario->email)
                    ->first();
                if ($alumno) {
                    $this->actualizarImagen($alumno, 'image', 'public/imagenes_alumnos');
                    $alumno->save();
                }
                break;
            case 'administrador':
                $this->actualizarImagen($usuario, 'image', 'public/imagenes_administradores');
                $usuario->save();
                return redirect(route('admin.dashboard'))->with('exito', 'Perfil actualizado con éxito');
            case 'secretario':
                $secretario = Secretario::where('nombre1', $usuario->name)
                    ->where('apellidop', $usuario->apellido)
                    ->where('email_institucional', $usuario->email)
                    ->first();
                if ($secretario) {
                    $this->actualizarImagen($secretario, 'image', 'public/imagenes_secretarios');
                    $secretario->save();
                }
                break;
        }

        return redirect(route('dashboard', ['rol' => $rol]))->with('exito', 'Perfil actualizado con éxito');
    }
}
