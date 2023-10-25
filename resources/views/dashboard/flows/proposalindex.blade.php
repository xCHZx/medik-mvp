@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <!-- ESPACIO ARRIBA -->
@stop

@section('content')
<div class="container">
    <div id="tarjetas-container" class="row">
        <!-- Cards -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div>
                    <div class="card-header h4 py-2">Título del Flujo 1
                        <div class="card-subtitle h6 text-muted font-weight-normal mt-2">Nombre del Negocio</div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-3">
                    <p class="card-text my-3">Objetivo: Obj 1</p>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div>
                    <div class="card-header h4 py-2">Título del Flujo 2
                        <div class="card-subtitle h6 text-muted font-weight-normal mt-2">Nombre del Negocio</div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-3">
                    <p class="card-text my-3">Objetivo: Obj 3</p>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div>
                    <div class="card-header h4 py-2">Título del Flujo 3
                        <div class="card-subtitle h6 text-muted font-weight-normal mt-2">Nombre del Negocio</div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-3">
                    <p class="card-text my-3">Objetivo: Obj 2</p>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div>
                    <div class="card-header h4 py-2">Título del Flujo 4
                        <div class="card-subtitle h6 text-muted font-weight-normal mt-2">Nombre del Negocio</div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-3">
                    <p class="card-text my-3">Objetivo: Obj 1</p>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nuevo Flujo -->
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Flujo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        
    </script>
@stop