<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome');
//dashboar
// Dashboard Admin
Route::get('/dashboard/admin', 'DashboardAdminController@index')->middleware('can:dashboard_admin')->name('dashboard_admin');

Route::get('/dashboard/docente', 'DashboardDocenteController@index')->middleware('can:dashboard_docente')->name('dashboard_docente');

Route::get('/dashboard/secretario', 'DashboardSecretarioController@index')->middleware('can:dashboard_secretario')->name('dashboard_secretario');

Route::get('/dashboard/alumno', 'DashboardAlumnoController@index')->middleware('can:dashboard_alumno')->name('dashboard_alumno');

Route::get('/dashboard/postulante', 'DashboardPostulanteController@index')->middleware('can:dashboard_postulante')->name('dashboard_postulante');
//Crud usuarios
Route::resource('usuarios', 'UsuarioController')->middleware('can:dashboard_admin')->names([
    'index' => 'usuarios.index',
    'create' => 'usuarios.create',
    'store' => 'usuarios.store',
    'show' => 'usuarios.show',
    'edit' => 'usuarios.edit',
    'update' => 'usuarios.update',
    'destroy' => 'usuarios.destroy'
]);
Route::put('/usuarios/{usuario}/disable', 'UsuarioController@disable')->name('usuarios.disable')->middleware('can:dashboard_admin');
Route::put('/usuarios/{usuario}/enable', 'UsuarioController@enable')->name('usuarios.enable')->middleware('can:dashboard_admin');

//Crud docentes
Route::middleware(['can:dashboard_secretario'])->name('docentes.')->group(function () {
    Route::get('docentes', 'DocenteController@index')->name('index');
    Route::get('docentes/create', 'DocenteController@create')->name('create');
    Route::post('docentes', 'DocenteController@store')->name('store');
    Route::get('docentes/{docente}', 'DocenteController@show')->name('show');
    Route::get('docentes/{docente}/edit', 'DocenteController@edit')->name('edit');
    Route::put('docentes/{docente}', 'DocenteController@update')->name('update');
    Route::delete('docentes/{docente}', 'DocenteController@destroy')->name('destroy');
});

//crud paralelo
Route::middleware(['can:dashboard_admin'])->group(function () {
    Route::resource('paralelos', 'ParaleloController')->names([
        'index' => 'paralelos.index',
        'create' => 'paralelos.create',
        'store' => 'paralelos.store',
        'show' => 'paralelos.show',
        'edit' => 'paralelos.edit',
        'update' => 'paralelos.update',
        'destroy' => 'paralelos.destroy'
    ]);
    Route::resource('secretarios', 'SecretarioController')->names([
        'index' => 'secretarios.index',
        'create' => 'secretarios.create',
        'store' => 'secretarios.store',
        'show' => 'secretarios.show',
        'edit' => 'secretarios.edit',
        'update' => 'secretarios.update',
        'destroy' => 'secretarios.destroy'
    ]);

});


Route::middleware(['can:dashboard_secretario'])->name('alumnos.')->group(function () {
    Route::get('alumnos', 'AlumnoController@index')->name('index');
    Route::get('alumnos/create', 'AlumnoController@create')->name('create');
    Route::post('alumnos', 'AlumnoController@store')->name('store');
    Route::get('alumnos/{alumno}/edit', 'AlumnoController@edit')->where('alumno', '.*')->name('edit');
    Route::put('alumnos/{alumno}', 'AlumnoController@update')->where('alumno', '.*')->name('update');
    Route::delete('alumnos/{alumno}', 'AlumnoController@destroy')->where('alumno', '.*')->name('destroy');
});

Route::middleware(['can:dashboard_admin'])->name('maestrias.')->group(function () {
    Route::get('maestrias', 'MaestriaController@index')->name('index');
    Route::get('maestrias/create', 'MaestriaController@create')->name('create');
    Route::post('maestrias', 'MaestriaController@store')->name('store');
    Route::get('maestrias/{maestria}', 'MaestriaController@show')->name('show');
    Route::get('maestrias/{maestria}/edit', 'MaestriaController@edit')->name('edit');
    Route::put('maestrias/{maestria}', 'MaestriaController@update')->name('update');
    Route::delete('maestrias/{maestria}', 'MaestriaController@destroy')->name('destroy');
    Route::put('maestrias/{maestria}/disable', 'MaestriaController@disable')->name('disable');
    Route::put('maestrias/{maestria}/enable', 'MaestriaController@enable')->name('enable');
});

Route::get('/asignaturas_docentes/create/{docente_id}', 'AsignaturaDocenteController@create')->where('docente_id', '.*')->name('asignaturas_docentes.create1');

Route::middleware(['can:dashboard_admin'])->name('asignaturas.')->group(function () {
    Route::get('/asignaturas', 'AsignaturaController@index')->name('index');
    Route::get('/asignaturas/create', 'AsignaturaController@create')->name('create');
    Route::post('/asignaturas', 'AsignaturaController@store')->name('store');
    Route::get('/asignaturas/{asignatura}', 'AsignaturaController@show')->name('show');
    Route::get('/asignaturas/{asignatura}/edit', 'AsignaturaController@edit')->name('edit');
    Route::put('/asignaturas/{asignatura}', 'AsignaturaController@update')->name('update');
    Route::delete('/asignaturas/{asignatura}', 'AsignaturaController@destroy')->name('destroy');
});

Route::middleware(['can:dashboard_secretario'])->name('asignaturas_docentes.')->group(function () {
    Route::get('/asignaturas_docentes', 'AsignaturaDocenteController@index')->name('index');
    Route::get('/asignaturas_docentes/create/{docente_id}', 'AsignaturaDocenteController@create')
    ->where('docente_id', '.*') // Acepta DNIs con un cero al principio o sin cero
    ->name('create1');
    Route::post('/asignaturas_docentes', 'AsignaturaDocenteController@store')->name('store');
    Route::get('/asignaturas_docentes/{asignatura_docente}', 'AsignaturaDocenteController@show')->name('show');
    Route::get('/asignaturas_docentes/{asignatura_docente}/edit', 'AsignaturaDocenteController@edit')->name('edit');
    Route::put('/asignaturas_docentes/{asignatura_docente}', 'AsignaturaDocenteController@update')->name('update');
    Route::delete('/asignaturas_docentes/{asignatura_docente}', 'AsignaturaDocenteController@destroy')->name('destroy');
});

Route::middleware(['can:dashboard_admin'])->name('aulas.')->group(function () {
    Route::get('aulas', 'AulaController@index')->name('index');
    Route::get('aulas/create', 'AulaController@create')->name('create');
    Route::post('aulas', 'AulaController@store')->name('store');
    Route::get('aulas/{aula}', 'AulaController@show')->name('show');
    Route::get('aulas/{aula}/edit', 'AulaController@edit')->name('edit');
    Route::put('aulas/{aula}', 'AulaController@update')->name('update');
    Route::delete('aulas/{aula}', 'AulaController@destroy')->name('destroy');
});

Route::middleware(['can:dashboard_admin'])->name('periodos_academicos.')->group(function () {
    Route::get('periodos_academicos', 'PeriodoAcademicoController@index')->name('index');
    Route::get('periodos_academicos/create', 'PeriodoAcademicoController@create')->name('create');
    Route::post('periodos_academicos', 'PeriodoAcademicoController@store')->name('store');
    Route::get('periodos_academicos/{periodo_academico}', 'PeriodoAcademicoController@show')->name('show');
    Route::get('periodos_academicos/{periodo_academico}/edit', 'PeriodoAcademicoController@edit')->name('edit');
    Route::put('periodos_academicos/{periodo_academico}', 'PeriodoAcademicoController@update')->name('update');
    Route::delete('periodos_academicos/{periodo_academico}', 'PeriodoAcademicoController@destroy')->name('destroy');
});

Route::middleware(['can:dashboard_secretario'])->name('cohortes.')->group(function () {
    Route::get('cohortes', 'CohorteController@index')->name('index');
    Route::get('cohortes/create', 'CohorteController@create')->name('create');
    Route::post('cohortes', 'CohorteController@store')->name('store');
    Route::get('cohortes/{cohort}', 'CohorteController@show')->name('show');
    Route::get('cohortes/{cohort}/edit', 'CohorteController@edit')->name('edit');
    Route::put('cohortes/{cohort}', 'CohorteController@update')->name('update');
    Route::delete('cohortes/{cohort}', 'CohorteController@destroy')->name('destroy');
});

Route::get('/cohortes_docentes/create/{docente_id}', ['uses' => 'CohorteDocenteController@create'])->where('docente_id', '.*')->middleware('can:dashboard_secretario');
Route::get('/cohortes_docentes/create/{docente_id}/{asignatura_id}', ['uses' => 'CohorteDocenteController@create'])->where('docente_id', '.*')->middleware('can:dashboard_secretario');
Route::resource('cohortes_docentes', 'CohorteDocenteController', ['names' => [
    'create' => 'cohortes_docentes.create',
    'store' => 'cohortes_docentes.store',
    'index' => 'cohortes_docentes.index',
    'edit' => 'cohortes_docentes.edit',
    'update' => 'cohortes_docentes.update',
    'show' => 'cohortes_docentes.show',
    'destroy' => 'cohortes_docentes.destroy'
]])->middleware('can:dashboard_secretario');

Route::get('/matriculas/create/{alumno_id}', 'MatriculaController@create')->where('alumno_id', '.*')->middleware('can:dashboard_secretario');
Route::get('/matriculas/create/{alumno_id}/{cohorte_id}', 'MatriculaController@create')->where('alumno_id', '.*')->middleware('can:dashboard_secretario');
Route::resource('matriculas', 'MatriculaController')->parameters(['matriculas' => 'id'])->names([
    'index' => 'matriculas.index',
    'create' => 'matriculas.create',
    'store' => 'matriculas.store',
    'show' => 'matriculas.show',
    'edit' => 'matriculas.edit',
    'update' => 'matriculas.update',
    'destroy' => 'matriculas.destroy'
])->middleware('can:dashboard_secretario');


Route::get('/calificaciones/create/{docente_id}/{asignatura_id}/{cohorte_id}', ['as' => 'calificaciones.create1', 'uses' => 'CalificacionController@create'])->where('docente_id', '.*')->middleware('can:dashboard_docente');
Route::get('/calificaciones/show/{alumno_id}/{docente_id}/{asignatura_id}/{cohorte_id}', ['as' => 'calificaciones.show1', 'uses' => 'CalificacionController@show'])->where('alumno_id', '.*')->where('docente_id', '.*')->middleware('can:dashboard_docente');
Route::get('/calificaciones/edit/{alumno_id}/{docente_id}/{asignatura_id}/{cohorte_id}', ['as' => 'calificaciones.edit1', 'uses' => 'CalificacionController@edit'])->where('docente_id', '.*')->middleware('can:dashboard_docente');

Route::resource('calificaciones', 'CalificacionController')->names([
    'index' => 'calificaciones.index',
    'create' => 'calificaciones.create',
    'store' => 'calificaciones.store',
    'show' => 'calificaciones.show',
    'edit' => 'calificaciones.edit',
    'update' => 'calificaciones.update',
    'destroy' => 'calificaciones.destroy'
])->middleware('can:dashboard_docente');


Route::put('/perfiles/actualizar', 'PerfilController@actualizar_p')->name('perfil.actualizar');

Route::resource('perfiles', 'PerfilController')->names([
    'index' => 'perfiles.index',
    'create' => 'perfiles.create',
    'store' => 'perfiles.store',
    'edit' => 'perfiles.edit',
    'update' => 'perfiles.update',
    'destroy' => 'perfiles.destroy',
])->except('show');

Route::resource('secciones', 'SeccionController')->names([
    'index' => 'secciones.index',
    'create' => 'secciones.create',
    'store' => 'secciones.store',
    'edit' => 'secciones.edit',
    'update' => 'secciones.update',
    'destroy' => 'secciones.destroy'
])->middleware('can:dashboard_admin');


Route::resource('record', 'RecordController')->names([
    'index' => 'record.index',
    'create' => 'record.create',
    'store' => 'record.store',
    'edit' => 'record.edit',
    'update' => 'record.update',
    'destroy' => 'record.destroy'
])->middleware('can:dashboard_secretario');

Route::middleware(['can:dashboard_admin'])->name('notas.')->group(function () {

    Route::get('notas/create/{id_alumno}', 'NotaController@create')->where('id_alumno', '.*')->name('create');
    Route::post('notas', 'NotaController@store')->name('store');
    Route::get('notas/{id_alumno}', 'NotaController@index')->where('id_alumno', '.*')->name('index');
    Route::get('notas/{id_alumno}/edit', 'NotaController@edit')->where('id_alumno', '.*')->name('edit');
    Route::put('notas/{id_alumno}', 'NotaController@update')->where('id_alumno', '.*')->name('update');
    Route::delete('notas/{id_alumno}', 'NotaController@destroy')->where('id_alumno', '.*')->name('destroy');
});

Route::get('/generar-pdf/{docenteId}/{asignaturaId}/{cohorteId}/{aulaId}/{paraleloId}', 'NotasAsignaturaController@show')->where('docenteId', '.*')->middleware(['can:dashboard_docente'])->name('pdf.notas.asignatura');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/enviar-correo', 'CorreoController@formulario')->name('formulario-correo');
Route::post('/enviar-correo', 'CorreoController@enviarCorreo')->name('enviar-correo');
Route::get('/cancelar-envio', 'CorreoController@cancelarEnvio')->name('cancelar-envio');


Route::get('/exportar-excel/{docenteId}/{asignaturaId}/{cohorteId}/{aulaId}/{paraleloId}', 'DashboardDocenteController@exportarExcel')->name('exportar.excel');

Route::get('/inicio', 'InicioController@redireccionarDashboard')->name('inicio');


Route::post('mensajes', 'MessageController@store')->name('messages.store');
Route::get('mensajes/buzon', 'MessageController@index')->name('messages.index');
Route::delete('/mensajes/{id_message}', 'MessageController@destroy')->name('messages.destroy');

Route::get('postulacion/create', 'PostulanteController@create')->name('postulantes.create');
Route::post('postulacion', 'PostulanteController@store')->name('postulantes.store');
Route::get('postulacion', 'PostulanteController@index')->name('postulantes.index');
Route::delete('postulacion/{dni}', 'PostulanteController@destroy')->where('dni', '.*')->name('postulantes.destroy');