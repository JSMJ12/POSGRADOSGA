<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected function sendResetResponse($response)
    {
        if (Auth::user()->hasRole('Administrador')) {
            return redirect()->route('dashboard_admin');
        } elseif (Auth::user()->hasRole('Docente')) {
            return redirect()->route('dashboard_docente');
        } elseif (Auth::user()->hasRole('Secretario')) {
            return redirect()->route('dashboard_secretario');
        } elseif (Auth::user()->hasRole('Alumno')) {
            return redirect()->route('dashboard_alumno');
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

}
