@extends('adminlte::page')

@section('title', 'Mi Cuenta')

@section('content_header')
    <div class="mt-3">
        <h1 class="text-center"><b>Edición</b> de la Cuenta</h1>
    </div>
@stop

@section('content')

    <div class="container my-2 px-0 mx-1 flex justify-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <form id="editar-nombre-form" method="post" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="form-group mt-2.5">
                        <label for="firstName">Nombre(s)</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="{{ old('firstName', $user->firstName) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Apellido(s)</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="{{ old('lastName', $user->lastName) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Número de Celular</label>
                        <input type="tel" pattern="[0-9]{9,10}" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="mt-4 flex justify-content-end">
                        <button type="submit" class="mdkbtn-success py-2 px-3">Guardar y regresar</button>
                        <a href="{{route('profile.index')}}" role="button" class="mdkbtn-danger py-2 px-3 ml-md-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
  
    
@stop

