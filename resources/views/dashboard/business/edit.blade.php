@extends('adminlte::page')

@section('title', 'Mi Negocio')

@section('content_header')

    @if ($business)
        <h1 class="mt-2 mb-2">Editando: <b>{{$business["name"]}}</b></h1>
    @else
        <h1 class="mt-3">Actualmente <b>no</b> tienes ningún negocio registrado</h1>
        <h2 class="mt-2 mb-3">Para utilizar la plataforma, crea tu primer negocio👇</h2>
    @endif


@stop

@section('content')
        <div class="card">
            <div class="card-body">
                <form class="p-3" method="POST" action="{{route('business.update', $business["id"])}}">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nombre del Negocio</label>
                            <input type="text" class="form-control mdkTextArea" value="{{$business["name"]}}"  name="name" id="name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control mdkTextArea" value="{{$business["address"]}}"  name="address" id="address" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción o slogan (opcional)</label>
                            <textarea class="form-control mdkTextArea"  name="description" id="description">{{$business["description"]}}</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input name="businessId" value="" type="hidden" />
                        <button type="submit" class="btn mdkbtn-success">Guardar y regresar</button>
                        <a href="{{route('business.index')}}" role="button" class="btn mdkbtn-danger">Cancelar</a>
                    </div>
                  </form>
            </div>
        </div>


@stop

@section('js')
    @if (session("action") == "ok")
        <script>
            Swal.fire(
                '¡Realizado!',
                'La acción se ha realizado con éxito',
                'success'
            )
        </script>
    @elseif (session("error") == "ok")
        <script>
            Swal.fire(
                '¡Error!',
                'Hubo un error con la operación, por favor verificar los campos o intenta más tarde',
                'warning'
            )
        </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

