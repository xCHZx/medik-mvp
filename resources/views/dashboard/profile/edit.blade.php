@extends('adminlte::page')

@section('title', 'Mi Cuenta')

@section('content_header')
<!-- ESPACIO ARRIBA -->
@stop

@section('content')

    <div class="container my-4 px-4 mx-1 flex justify-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <div class="card-header flex justify-content-center border-bottom border-success bg-green-50">
                    <h1 class="card-title text-center" style="font-weight: 600">Edición de la Cuenta</h1>
                </div>
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
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Número de Celular</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    </div>
                    <div class="mt-4 flex justify-content-end">
                        <button type="submit" class="btn btnmdk-confirm btnmdk-hover">Guardar y regresar</button>
                        <a href="{{route('profile.index')}}" role="button" class="btn btnmdk-cancel btnmdk-hover ml-md-2">Cancelar</a>
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

