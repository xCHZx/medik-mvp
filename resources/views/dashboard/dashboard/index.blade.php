@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <h1>Hola {{$user["firstName"]}}</h1>

    @if($status)
        <h2 class="mt-4 mb-3">Bienvenido al panel de administración de <b>medik</b></h2>
    @else
        <h1 class="mt-4">Actualmente <b>no</b> tienes una suscripción activa</h1>
        <h2 class="mt-3 mb-3">Para utilizar la plataforma, inicia tu suscripción👇</h2>
    @endif

@stop

@section('content')
    @if($status)
        <div>
            <h1>...</h1>
        </div>
    @else
    <div class="card">
        <div class="card-body">
            <h1>Para empezar una suscripción conoce nuestros planes</h1>
            <div class="mt-4 d-none d-sm-flex">
                <a href="{{route('subscription.index')}}" role="button" class="px-3 py-2 mdkbtn-success">Ir a los planes</a>
            </div>
            <!-- Mobile -->
            <div class="mt-4 d-block d-sm-none">
                <a href="{{route('subscription.index')}}" role="button" class="d-flex w-full px-3 py-2 mdkbtn-success">
                    <p class="text-center w-full">Ir a los planes</p>
                </a>
            </div>
        </div>
    </div>
    @endif

    @if($activeBusiness)
        <div class="card mt-5">
            <div class="card-body">
                <p>Nuevas visitas del último mes</p>
                <hr>
                <p>Opiniones positivas del ultimo mes</p>
                <hr>
                <p>Opiniones negativas del ultimo mes</p>
                <hr>
                <p>Total Visitas</p>
                <hr>
                <p>Variación visitas</p>
                <hr>
                <p>Total Opiniones</p>
                <hr>
                <p>Variación opiniones mes pasado</p>
                <hr>
                <p>Total Opiniones Positivas</p>
                <hr>
                <p>Total Opiniones Negativas</p>
                <hr>
                <p>Últimas 3 opiniones</p>
                <hr>
                <p>Flujo activo</p>
                <hr>
                <p>Negocio activo</p>
                <hr>
            </div>
        </div>
    @endif
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

