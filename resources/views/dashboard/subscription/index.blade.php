@extends('adminlte::page')

@section('title', 'Suscripciones')

@section('content_header')
  <section class="mt-3">
    {{-- <h1>Hola {{$user["firstName"]." ".$user["lastName"]}}</h1> --}}
    <h1 class="text-center"> Suscripciones</h1>
  </section>

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
      <section class="container my-2 px-0 mx-1 flex justify-center"">
        <div class="row">
          <div class="card text-center">
            <div class="card-header text-center border-bottom-0 bg-transparent text-success pt-4 text-2xl">
              <h5>Suscripción <b>Mensual</b></h5>
            </div>
            <div class="card-body">
              <h1 class="price text-5xl font-semibold">$399</h1>
              <h5 class="text-muted text-sm pt-2">Mensual</h5>
            </div>
            <article class="px-8 mt-2">
              <ul class="list-group list-group-flush px-0 border border-gray-500 rounded-3xl">
                <li class="list-group-item">
                  <i class="fas fa-male text-success mx-2"></i>Mejora y aumenta tu reputación en internet
                </li>
                <li class="list-group-item">
                  <i class="fab fa-whatsapp text-success mx-2"></i>Incrementa tus visitas con recordatorios por WhatsApp
                </li>
                <li class="list-group-item">
                  <i class="fas fa-chart-line text-success mx-2"></i>Lleva seguimiento de las métricas de tus visitas
                </li>
              </ul>
            </article>
            <div class="card-footer border-top-0 px-8 my-2">
              <form method="POST" target="_blank" action="{{route('subscription.checkout')}}">
                @csrf
                <button type="submit" class="btn mdkbtn-success w-full">Adquirir</button>
              </form>
            </div>
          </div>
        </div>
      </section>
    @endif
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

