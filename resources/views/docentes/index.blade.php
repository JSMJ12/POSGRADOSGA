@extends('adminlte::page')
@section('title', 'Docentes')
@section('content_header')
    <h1>Docentes</h1>
@stop
@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('docentes.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if (isset($docentes))
            <table class="table" id="docentes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nombre completo</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Asignaturas</th>
                        <th>Cohortes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($docentes as $docente)
                        <tr>
                            <td>{{ $docente->dni }}</td>
                            <td class="text-center">
                                <img src="{{ asset($docente->image) }}" alt="Imagen de {{ $docente->name }}" style="max-width: 60px; border-radius: 50%;">
                            </td>
                            <td>{{ $docente->nombre1 }}<br>{{ $docente->nombre2 }}<br>{{ $docente->apellidop }}<br>{{ $docente->apellidom }}</td>
                            <td>{{ $docente->email }}</td>
                            <td>{{ $docente->tipo }}</td>
                            <td>
                                <ul>
                                    @foreach($docente->asignaturas as $asignatura)
                                        <li>{{ $asignatura->nombre }}</li>
                                    @endforeach
                                </ul>
                            </td> 
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cohortesModal{{ $docente->dni }}" title="Ver Cohortes">
                                    <i class="fas fa-eye"></i>
                                </button>                                
                            </td>                               
                            
                            <td style="width: 250px;">
                                <div style="display: block; margin-bottom: 10px;">
                                    <div class="col-sm-6">
                                        <a href="{{ route('docentes.edit', $docente->dni) }}" class="btn btn-primary custom-btn btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="col-sm-6">
                                            <a href="{{ route('asignaturas_docentes.create1', $docente->dni) }}" class="btn btn-success custom-btn btn-sm" title="Agregar Asignaturas">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="col-sm-6">
                                        <a href="{{ url('/cohortes_docentes/create', $docente->dni) }}" class="btn btn-warning custom-btn btn-sm" title="Agregar Cohortes">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        
                                    </div>
                                </div>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

@foreach ($docentes as $docente)
    <!-- Modal para mostrar información de cohortes -->
    <div class="modal fade" id="cohortesModal{{ $docente->dni }}" tabindex="-1" role="dialog" aria-labelledby="cohortesModalLabel{{ $docente->dni }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0e4439; color: white;">
                    <h5 class="modal-title" id="cohortesModalLabel{{ $docente->dni }}">Cohortes de {{ $docente->nombre1 }} {{ $docente->apellidop }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Maestría</th>
                                <th>Nombre del Cohorte</th>
                                <th>Modalidad</th>
                                <th>Aula</th>
                                <th>Paralelo</th>
                                <th>Asignaturas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $previousCohorteId = null; // Inicializamos una variable para rastrear el cohorte previo
                            @endphp
                        
                            @foreach($docente->cohortes as $cohorte)
                                @php
                                // Comparamos el ID del cohorte actual con el anterior
                                $isSameCohorte = $cohorte->id === $previousCohorteId;
                                $previousCohorteId = $cohorte->id; // Actualizamos el ID del cohorte previo
                                @endphp
                        
                                <tr>
                                    {{-- Mostramos datos del cohorte solo si es un cohorte diferente --}}
                                    @if (!$isSameCohorte)
                                        <td>{{ $cohorte->maestria->nombre }}</td>
                                        <td>{{ $cohorte->nombre }}</td>
                                        <td>{{ $cohorte->modalidad }}</td>
                                        <td>{{ $cohorte->aula->nombre }}</td>
                                        <td>{{ $cohorte->aula->paralelo->nombre }}</td>
                                        <td>
                                            <ul>
                                                @foreach($cohorte->asignaturas as $asignatura)
                                                    @if ($docente->asignaturas->contains($asignatura))
                                                        <li>{{ $asignatura->nombre }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                    @else
                                        {{-- De lo contrario, dejamos las celdas vacías --}}
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@stop

@section('css')
<style>

</style>
@stop

@section('js')
<script>
    $('#docentes').DataTable({
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