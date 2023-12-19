@extends('adminlte::page')

@section('title', 'Suscripciones')

@section('content_header')
    <section class="mt-3">
      <h1 class="text-left font-medium"> Suscripciones</h1>
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
      <section id="suscriptionsTypes" class="row my-2 px-0 mx-1 flex justify-start gap-x-6">
          <div class="card text-white w-2/5 p-3" style="background-color: #22836F">
            <div class="card-header border-bottom-0 bg-transparent text-[2.9rem]">
              <h5>Mejora tu reputación <br>
                  <b>y aumenta tus visitas</b>
              </h5>
            </div>
            <div class="card-body">
              <p class="text-lg">en internet a través de nuestro sistema automatizado de registro de visitas y opiniones</p>
              <p class="py-4 text-5xl">➜</p>
              <img class="img-fluid min-w-[90%]" alt="Doctor escribiendo" src="{{ url('/resources/images/suscription.svg') }}">
            </div>
          </div>

          <div class="card w-2/5 p-3">
            <div class="card-header border-bottom-0 bg-transparent text-[2.9rem] pb-0 mb-0">
              <div class="flex flex-row items-center p-0 mt-n2 ml-n2">
                <input
                  name="rating"
                  class="rating inline px-0 mx-0"
                  max="1"
                  style="--value:1; --stars: 1;"
                  type="range"
                  value="1"
                  required
                >
                <p class="inline align-middle justify-center pl-2"><b>Plan Básico</b></p>
              </div>
            </div>
            <div class="card-body py-2 flex flex-col justify-between">
              <h5 class="text-muted text-xl mt-1">Lo que obtendrás</h5>
              <ul class="list-none list-outside text-left mt-4 font-normal text-lg">
                <li class="pb-3 flex flex-row flex-nowrap items-center">
                  <i class="fas fa-check-circle pr-2 inline" style="color: #1EDDFF"></i>
                  <p class="inline-block">Permite a tus pacientes registrar sus visitas</p>
                </li>
                <li class="pb-3 flex flex-row flex-nowrap items-center">
                  <i class="fas fa-check-circle pr-2 inline" style="color: #1EDDFF"></i>
                  <p class="inline-block">Recibe opiniones sobre la calidad de tu servicio</p>
                </li>
                <li class="pb-3 flex flex-row flex-nowrap items-center">
                  <i class="fas fa-check-circle pr-2 inline" style="color: #1EDDFF"></i>
                  <p class="inline-block">Visualiza las estadísticas relevantes para ti</p>
                </li>
                <li class="pb-3 flex flex-row flex-nowrap items-center">
                  <i class="fas fa-check-circle pr-2 inline" style="color: #1EDDFF"></i>
                  <p class="inline-block w-full">Recursos educativos de marketing para el área médica</p>
                </li>
                <li class="pb-3 flex flex-row flex-nowrap items-center">
                  <i class="fas fa-check-circle pr-2 inline" style="color: #1EDDFF"></i>
                  <p class="inline-block">Recordatorios multicanal para tus pacientes</p>
                </li>
                <li class="pb-3 flex flex-row flex-nowrap items-center">
                  <i class="fas fa-check-circle pr-2 inline" style="color: #1EDDFF"></i>
                  <p class="inline-block">Manejo de agenda de citas</p>
                </li>
              </ul>
              <div class="flex flex-row items-end">
                <h2 class="text-5xl font-bold">$399</h2>
                <h5 class="text-lg font-semibold pl-2">(+IVA)/mes</h5>
              </div>
            </div>
            <div class="card-footer border-top-0 px-8 my-2">
              <form method="POST" target="_blank" action="{{route('subscription.checkout')}}">
                @csrf
                <button type="submit" class="btn mdkbtn-success w-full text-2xl font-semibold h-12">Adquirir</button>
              </form>
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

