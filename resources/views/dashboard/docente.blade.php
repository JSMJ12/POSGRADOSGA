@extends('adminlte::page')
@section('title', 'Dashboard Docente')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>Lista de alumnos matriculados</h3>

    <div class="container">
        @foreach ($asignaturas as $asignatura)
            <div class="card mb-4">
                <div class="card-header"><strong>{{ $asignatura->nombre }} </strong>
                </div>
                <div class="card-body">
                    <table class="table" id="docente">
                        <thead>
                            <tr>
                                <th>Cohorte</th>
                                <th>Nombre Completo</th>
                                <th>Calificar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asignatura->cohortes as $cohorte)
                                <tr>
                                    <td>{{ $cohorte->nombre }} Aula: {{ $cohorte->aula->nombre }}<br>Paralelo: {{ $cohorte->aula->paralelo->nombre }}</td>
                                    <td><a href="{{ route('pdf.notas.asignatura', [
                                        'docenteId' => $docente->dni,
                                        'asignaturaId' => $asignatura->id,
                                        'cohorteId' => $cohorte->id,
                                        'aulaId' => $cohorte->aula->id,
                                        'paraleloId' => $cohorte->aula->paralelo->id,
                                        ]) }}" class="btn btn-success btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Generar PDF de Notas
                                    </a></td>
                                    <td>
                                        <a href="{{ route('calificaciones.create1', [$docente->dni, $asignatura->id, $cohorte->id]) }}" class="btn btn-primary">Calificar</a>
                                    </td>
                                </tr>
                                @foreach ($cohorte->matriculas as $matricula)
                                    @if ($matricula->asignatura_id == $asignatura->id && $matricula->docente_dni == $docente->dni)
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($matricula->alumno->image) }}" alt="Imagen del alumno" class="img-thumbnail rounded-circle mr-3" style="width: 80px;">
                                                    <div>
                                                        <p class="mb-0 font-weight-bold">{{ $matricula->alumno->apellidop }} {{ $matricula->alumno->apellidom }} {{ $matricula->alumno->nombre1 }} {{ $matricula->alumno->nombre2 }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                
                                                <a href="{{ route('calificaciones.show1', [$alumno->dni, $docente->dni, $asignatura->id, $cohorte->id]) }}">Ver Notas</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@stop
@section('js')
<script>
    $('#docente').DataTable({
        lengthMenu: [5, 10, 15, 20, 40, 45, 50, 100], 
        pageLength: {{ $perPage }},
        responsive: true, 
        colReorder: true,
        keys: true,
        autoFill: true, 
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    });
</script>
@stop