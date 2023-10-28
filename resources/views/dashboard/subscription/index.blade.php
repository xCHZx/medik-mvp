@extends('adminlte::page')

@section('title', 'Suscripciones')

@section('content_header')
    {{-- <h1>Hola {{$user["firstName"]." ".$user["lastName"]}}</h1> --}}
    <h1> Suscripciones</h1>
@stop

@section('content')

    @if($status)
    <div class="card">
        <div class="card-header">
            <h1 class="my-3">Actualmente ya tienes una suscripción activa</h1>
            <h1>¿Necesitas ayuda? <b>Contáctanos</b></h1>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <a href="#" class="list-group-item"><i class="far fa-envelope fa-fw me-4"></i>ayuda@medik.mx</a>
                <a href="#" class="list-group-item"><i class="fab fa-whatsapp fa-fw me-4"></i>+52 000 000 0000</a>
            </ul>
    </div>

    @else
    <div class="container">
        <div class="row">
          <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card text-center">
              <div class="card-header text-center border-bottom-0 bg-transparent text-success pt-4">
                <h5>Suscripción <b>Mensual</b></h5>
              </div>
              <div class="card-body">
                <h1 class="price">$299</h1>
                <h5 class="text-muted"><small>Pago Mensual</small></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fas fa-male text-success mx-2"></i>Mejora y aumenta tu reputación en internet</li>
                <li class="list-group-item"><i class="fab fa-whatsapp text-success mx-2"></i>Aumenta tus visitas con recordatorios por WhatsApp</li>
                <li class="list-group-item"><i class="fas fa-chart-line text-success mx-2"></i>Lleva seguimiento de las métricas de tus visitas</li>
              </ul>
              <div class="card-footer border-top-0">
                <form method="POST" target="_blank" action="{{route('subscription.checkout')}}">
                    @csrf
                    <button type="submit" class="btn btn-outline-success">Adquirir</button>
                </form>
                {{-- <a href="{{route('subscription.checkout')}}" class="text-muted text-uppercase">Create Account <i class="fas fa-arrow-right"></i></a> --}}
              </div>
            </div>
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

