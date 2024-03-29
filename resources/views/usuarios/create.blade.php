@extends('adminlte::page')
@section('title', 'Crear Usuario')
@section('content_header')
    <h1>Crear Usuario</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="usu_nombre">Nombre:</label>
                    <input type="text" name="usu_nombre" id="usu_nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="usu_apellido">Apellido:</label>
                    <input type="text" name="usu_apellido" id="usu_apellido" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="usu_contrasena">Contraseña:</label>
                    <input type="password" name="usu_contrasena" id="usu_contrasena" class="form-control">
                </div>
                <div class="form-group">
                    <label for="usu_sexo">Sexo:</label>
                    <select name="usu_sexo" id="usu_sexo" class="form-control">
                        <option value="">Seleccione el sexo</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="roles">Roles:</label>
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}">
                            <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="usu_foto">Foto:</label>
                    <input type="file" name="usu_foto" id="usu_foto" class="form-control-file">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop