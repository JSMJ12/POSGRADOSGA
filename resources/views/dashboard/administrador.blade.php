@extends('adminlte::page')
@section('title', 'Dashboard Admin')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-2">
                <div class="col-sm-6">
                    <button id="mostrarGrafico" class="btn btn-primary">Mostrar Matriculados</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 hide-by-default"> <!-- Agrega la clase hide-by-default para ocultar el gráfico y la lista de maestrías por defecto -->
            <div class="card">
                <div class="card-body">
                    <canvas id="matriculadosChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id='alumnos'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Nombre Completo</th>
                                <th>Cedula/Pasaporte</th>
                                <th>Maestria</th>
                                <th>Email Institucional</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            <tr>
                                <td>{{ $alumno->dni }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($alumno->image) }}" alt="Imagen de {{ $alumno->name }}" style="max-width: 60px; border-radius: 50%;">
                                </td>
                                <td>
                                    {{ $alumno->nombre1 }}<br>
                                    {{ $alumno->nombre2 }}<br>
                                    {{ $alumno->apellidop }}<br>
                                    {{ $alumno->apellidom }}
                                </td>
                                <td>{{ $alumno->dni }}</td>
                                <td>{{ $alumno->maestria->nombre }}</td>
                                <td>{{ $alumno->email_institucional }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        .hide-by-default {
            display: none;
        }
        .maestria-nombre {
            font-size: 12px;
            font-family: 'Times New Roman', Times, serif; /* Ajusta el tamaño de fuente según tu preferencia */
        }

        /* Estilo para el ID de maestría */
        .maestria-id {
            font-weight: bold; /* Texto en negrita para el ID */
            margin-right: 3px; /* Espacio entre el ID y el nombre */
            cursor: pointer; /* Cambia el cursor al hacer hover sobre el ID */
        }
    </style>
@stop

@section('js')
    <script>
        $('#alumnos').DataTable({
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

       // Datos para el gráfico de matriculados por maestría
        var matriculadosIDs = {!! $matriculadosPorMaestria->pluck('id') !!};
        var matriculadosNames = {!! $matriculadosPorMaestria->pluck('nombre') !!};
        var matriculadosValues = {!! $matriculadosPorMaestria->pluck('alumnos_count') !!};

        var matriculadosData = {
            labels: matriculadosIDs,
            datasets: [{
                label: 'Cantidad de Alumnos Matriculados',
                data: matriculadosValues,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        var matriculadosOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = matriculadosNames[context.dataIndex] + ' (ID ' + matriculadosIDs[context.dataIndex] + '): ' + context.parsed.y + ' alumnos matriculados';
                            return label;
                        }
                    }
                }
            }
        };


        var matriculadosChart = new Chart(document.getElementById('matriculadosChart'), {
            type: 'bar',
            data: matriculadosData,
            options: matriculadosOptions
        });

        $(document).ready(function () {
            var graficoVisible = false; // Variable para rastrear si el gráfico y la lista están visibles

            $('#mostrarGrafico').click(function () {
                if (graficoVisible) {
                    // Si el gráfico y la lista están visibles, los ocultamos
                    $('.hide-by-default').hide();
                    graficoVisible = false;
                    $(this).text('Mostrar Matriculados'); // Cambiar el texto del botón
                } else {
                    // Si el gráfico y la lista están ocultos, los mostramos
                    $('.hide-by-default').show();
                    graficoVisible = true;
                    $(this).text('Ocultar Matriculados'); // Cambiar el texto del botón
                }
            });
        });
    </script>
@stop