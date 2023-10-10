@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <h1>Crear Flujo</h1>
@stop

@section('content')
    <p>LLena nos campos del formulario para <b>Crear un flujo</b></p>
    
    <form method="post" action="{{ route('flows.store') }}">
                @csrf

                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label class="form-label" for="name" >Nombre</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{old('name')}}">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label class="form-label" for="waitingHours" >Tiempo de espera en horas para lanzar el primer mensaje</label>
                    <input class="form-control" type="number" id="waitingHours" name="waitingHours" value="{{old('waitingHours')}}">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label for="forwardingTime"  class="form-label">Tiempo en minutos para enviar un mensaje de recordatorio</label>
                    <input class="form-control" type="number" id="forwardingTime" name="forwardingTime" value="{{old('forwardingTime')}}">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-outline-info">Guardar</button>
                </div>
                
            
            </form>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop