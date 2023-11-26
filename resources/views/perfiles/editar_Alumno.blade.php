@extends('adminlte::page')
@section('title', 'Editar Perfil')
@section('content_header')
    <h1>Editar Perfil</h1>
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Campo de imagen -->
                        <div class="form-group row">
                            <label for="imagen" class="col-md-4 col-form-label text-md-right">{{ __('Imagen') }}</label>
                            <div class="col-md-6">
                                <input id="imagen" type="file" class="form-control-file @error('imagen') is-invalid @enderror" name="image">
                                @error('imagen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Checkbox para cambiar la contraseña -->
                        <div class="form-group">
                            <label for="cambiar-contrasena">Cambiar contraseña</label>
                            <input type="checkbox" name="cambiar-contrasena" id="cambiar-contrasena">
                        </div>

                        <!-- Formulario de contraseña actual (visible si el checkbox está marcado) -->
                        <div class="form-group @if(old('cambiar-contrasena')) d-block @else d-none @endif" id="contrasena-form1">
                            <label for="password_actual">Contraseña Actual</label>
                            <input type="password" name="password_actual" class="form-control">
                            @error('password_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Formulario de nueva contraseña (visible si el checkbox está marcado) -->
                        <div class="form-group @if(old('cambiar-contrasena')) d-block @else d-none @endif" id="contrasena-form2">
                            <label for="password_nueva">Nueva contraseña</label>
                            <input type="password" name="password_nueva" class="form-control">
                        </div>

                        <!-- Botón de guardar cambios -->
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')                  
<script>
    // Mostrar u ocultar el campo de contraseña según el estado del checkbox
    const checkbox = document.getElementById('cambiar-contrasena');
    const contrasenaForm = document.getElementById('contrasena-form1');
    const contrasenaForm1 = document.getElementById('contrasena-form2');
    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            contrasenaForm.style.display = 'block';
            contrasenaForm1.style.display = 'block';
        } else {
            contrasenaForm.style.display = 'none';
            contrasenaForm1.style.display = 'none';
        }
    });
</script>
@stop