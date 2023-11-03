@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <h1>Hola {{$user["firstName"]}}</h1>

    @if($status)
        <h2 class="mt-2 mb-5">Bienvenido al panel de administración de <b>medik</b></h2>
    @else
        <h1 class="mt-5">Actualmente <b>no</b> tienes una suscripción activa</h1>
        <h2 class="mt-2 mb-5">Para utilizar la plataforma, inicia tu suscripción👇</h2>
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
            <div class="mt-3">
                <a href="{{route('subscription.index')}}" role="button" class="btn btn-outline-success">Ir a los planes</a>
            </div>
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

