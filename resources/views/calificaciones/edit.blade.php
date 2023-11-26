@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@extends('adminlte::page')
@section('title', 'Calificar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Editar notas del alumno</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('calificaciones.update', $nota->id) }}">
                        @csrf
                        @method('PUT')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Actividades</th>
                                    <th>Prácticas</th>
                                    <th>Autónomo</th>
                                    <th>Examen final</th>
                                    <th>Recuperación</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="number" step="0.01" class="form-control" name="nota_actividades" value="{{ old('nota_actividades', $nota->first()->nota_actividades) }}" max="3.0"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="nota_practicas" value="{{ old('nota_practicas', $nota->first()->nota_practicas) }}" max="3.0"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="nota_autonomo" value="{{ old('nota_autonomo', $nota->first()->nota_autonomo) }}" max="3.0"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="examen_final" value="{{ old('examen_final', $nota->first()->examen_final) }}" max="3.0"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="recuperacion" value="{{ old('recuperacion', $nota->first()->recuperacion) }}" max="3.0"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="total" value="{{ old('total', $nota->first()->total) }}"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Actualizar notas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop