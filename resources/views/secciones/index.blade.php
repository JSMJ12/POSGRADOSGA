@extends('adminlte::page')
@section('title', 'Secciones')
@section('content_header')
    <h1>Secciones</h1>
@stop
@section('content')
<div class="container">
    <div class="col-md-4">
        <a href="{{ route('secciones.create') }}" class="btn btn-success">Crear Sección</a>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-body">
                    <table class="table table-bordered" id="secciones">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Maestrías</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secciones as $seccion)
                                <tr>
                                    <td>{{ $seccion->id }}</td>
                                    <td>{{ $seccion->nombre }}</td>
                                    <td>
                                        @foreach ($seccion->maestrias as $maestria)
                                            {{ $maestria->nombre }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <form action="{{ route('secciones.destroy', $seccion) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar esta sección?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $('#secciones').DataTable({
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