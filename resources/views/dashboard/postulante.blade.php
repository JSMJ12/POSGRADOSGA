@extends('layouts.app')
<title>Postulación</title>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <img src="{{ asset('images/unesum.png') }}" alt="University Logo" class="logo">
                        <img src="{{ asset('images/posg.jpg') }}" alt="University Seal" class="seal"><br><span class="university-name">UNIVERSIDAD ESTATAL DEL SUR DE MANABÍ</span><br>
                        <span class="institute">INSTITUTO DE POSGRADO</span><br>
                    </div>
                    <div class="divider"></div>
                    <div class="card-body">
                        <div class="form-group custom-select-wrapper">
                            <label for="maestria_id">Maestría a Postular:</label>
                            <select class="custom-select" id="maestria_id" name="maestria_id" required>
                                <option value="" disabled selected>Seleccione una maestría</option>
                                @foreach($maestrias as $maestria)
                                    <option value="{{ $maestria->id }}">
                                        <strong>{{ $maestria->nombre }}</strong><br>
                                        <span class="text-muted">Precio:</span> {{ $maestria->precio_total }}<br>
                                        <span class="text-muted">Inicio:</span> {{ $maestria->fecha_inicio }}<br>
                                        <span class="text-muted">Fin:</span> {{ $maestria->fecha_fin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="imagen">Imagen:</label>
                            <input type="file" name="imagen" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label for="pdf_cedula">PDF Cédula / Pasaporte:</label>
                            <input type="file" name="pdf_cedula" class="form-control-file" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label for="pdf_papelvotacion">PDF Papel de Votación:</label>
                            <input type="file" name="pdf_papelvotacion" class="form-control-file" accept=".pdf">
                        </div>

                        <div class="form-group">
                            <label for="pdf_titulouniversidad">PDF Título de Universidad:</label>
                            <input type="file" name="pdf_titulouniversidad" class="form-control-file" accept=".pdf">
                        </div>

                        <div class="form-group" id="divPDFConadis" style="display: none;">
                            <label for="pdf_conadis">PDF CONADIS:</label>
                            <input type="file" name="pdf_conadis" class="form-control-file" accept=".pdf">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop