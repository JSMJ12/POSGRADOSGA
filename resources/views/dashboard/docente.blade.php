@extends('adminlte::page')
@section('title', 'Dashboard Docente')
@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        @foreach ($data as $asignatura)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>{{ $asignatura['nombre'] }}</strong>
                </div>
                @foreach ($asignatura['cohortes'] as $cohorte)
                    <div class="card-header">
                        <strong>{{ $cohorte['nombre'] }}  Aula:</strong> {{ $cohorte['aula'] }} <strong> Paralelo: </strong> {{ $cohorte['paralelo'] }} <strong> Fecha límite: </strong> {{$cohorte['fechaLimite']}}
                        <div class="float-right">
                            <a href="{{ $cohorte['pdfNotasUrl'] }}" class="btn btn-success btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF de Notas
                            </a>
                            <a href="{{ $cohorte['excelUrl'] }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Lista de Alumnos
                            </a>
                            @if ($cohorte['fechaLimite'] >= now())
                                <a href="{{ $cohorte['calificarUrl'] }}" class="btn btn-primary btn-sm">Calificar</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="docente">
                            <thead>
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Calificar / Ver Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($cohorte['alumnos']))
                                    @foreach ($cohorte['alumnos'] as $alumno)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($alumno['imagen']) }}" alt="Imagen del alumno" class="img-thumbnail rounded-circle mr-3" style="width: 80px;">
                                                    <div>
                                                        <p class="mb-0 font-weight-bold">{{ $alumno['nombreCompleto'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ $alumno['verNotasUrl'] }}">Ver Notas</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No hay alumnos en este cohorte.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@stop