@extends('adminlte::page')

@section('title', 'Mi Negocio')

@section('content_header')
    <h1>Hola {{$user["name"]}}</h1>
@stop

@section('content')
    <p>Bienvenido al panel de administración de <b>medik</b></p>

    @if ($business)
        <p>{{$business}}</p>

        <html>{!!$svg!!}</html>

    @else

        <div class="card">
            <div class="card-body">
                <form class="p-3" method="POST" action="{{route('business.store')}}"">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nombre del Negocio</label>
                            <input type="text" class="form-control"  name="name" id="name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="lastName" class="form-label">Descripción (opcional)</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input name="businessId" value="" type="hidden" />
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                  </form>
            </div>
        </div>
    @endif

@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

