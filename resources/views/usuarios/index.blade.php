@extends('adminlte::page')
@section('title', 'Usuarios')
@section('content_header')
    <h1>Usuarios</h1>
@stop
@section('css')
@stop
@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
    @if (isset($usuarios))
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" style="width:100%" id="usuarios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            @can('admin.usuarios.disable')
                                <th>Estatus</th>
                                <th>Roles</th>
                                <th>Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td class="text-center">{{ $usuario->id }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($usuario->image) }}" alt="Imagen de {{ $usuario->name }}" style="max-width: 60px; border-radius: 50%;">
                                </td>
                                <td class="text-center">{{ $usuario->name }}</td>
                                <td class="text-center">{{ $usuario->apellido }}</td>
                                <td class="text-center">{{ $usuario->email }}</td>
                                @can('admin.usuarios.disable')
                                    <td class="text-center">{{ $usuario->status }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($usuario->roles as $role)
                                                <li>{{ $role->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary">Editar</a>
                                        @if ($usuario->status == 'ACTIVO')
                                            <form action="{{ route('usuarios.disable', $usuario->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger">Deshabilitar</button>
                                            </form>
                                        @else
                                            <form action="{{ route('usuarios.enable', $usuario->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Reactivar</button>
                                            </form>
                                        @endif
                                    </td>
                                @endcan 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>   
    @endif
</div>
@stop
@section('js')
<script>
    $('#usuarios').DataTable({
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
