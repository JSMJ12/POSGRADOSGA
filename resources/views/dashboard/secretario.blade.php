@extends('adminlte::page')
@section('title', 'Dashboar Admin')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Contenido</h3>
                        </div>
                        <div class="box-body">
                            <p>Bienvenido</p>
                            <p>Contenido exclusivo para usuarios con el rol de secretario.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script> console.log('Hi!'); </script>
@stop