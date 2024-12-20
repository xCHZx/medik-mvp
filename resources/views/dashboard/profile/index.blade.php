@extends('adminlte::page')

@section('title', 'Mi Cuenta')

@section('content_header')
<!-- ESPACIO ARRIBA -->
@stop

@section('content')
    @if(session('status') === 'profile-updated')
       @section('js')
          <script>
              Swal.fire(
                   'Listo!',
                   'Tu informacion ha sido actualizada!',
                   'success'
                )
          </script>   
      @stop       
    @endif
    
    @if (session('status') === 'password-updated')
        @section('js')
            <script>
                Swal.fire(
                    'Listo!',
                    'Tu contraseña ha sido actualizada!',
                    'success'
                )
            </script>   
        @stop  
    @endif

    @if (session('status') === 'password-error')
        @section('js')
            <script>
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Tu contraseña actual es incorrecta o intentas usar la misma como la nueva!',
                })
            </script>   
        @stop  
    @endif

    <div class="container my-4 px-4 mx-1">
        <div class="card">
            <div class="card-body">
                <div class="card-header flex justify-content-center border-bottom border-success bg-green-50">
                    <h1 class="card-title text-center" style="font-weight: 600">Información de la Cuenta</h1>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item border-bottom border-secondary">
                        <div class="row flex justify-content-between">
                            <div class="col-md-4 text-md-left d-flex align-items-center">
                                <h2 class="card-subtitle" style="font-weight: 500">Datos del perfil</h2> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end align-items-center">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-info btn-sm" target="_self" role="button">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                    Editar Datos
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ml-4">
                        <div class="row">
                            <div class="col-md-3 text-md-left d-flex align-items-center">
                                <p class="fw-medium">Nombre Completo:</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <span style="font-weight: 300" id="cliente-nombre">{{ $user->firstName }} {{ $user->lastName }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ml-4">
                        <div class="row">
                            <div class="col-md-3 text-md-left d-flex align-items-center">
                                <p>Correo Electrónico:</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <span style="font-weight: 300" id="cliente-correo">{{ $user->email }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ml-4">
                        <div class="row">
                            <div class="col-md-3 text-md-left text-center d-flex align-items-center">
                                <p>Número de Celular:</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <span style="font-weight: 300" id="cliente-telefono">{{ $user->phone }}</span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-bottom border-secondary">
                        <div class="row flex justify-content-between">
                            <div class="col-md-4 text-md-left d-flex align-items-center">
                                <h2 class="card-subtitle text-center" style="font-weight: 500">Seguridad</h2> 
                            </div>
                            <div class="col-md-3 d-flex justify-content-end align-items-center">
                                <a href="{{ route('profile.change-password') }}" class="btn btn-outline-info btn-sm" target="_self" role="button">
                                    <i class="fas fa-user-lock" aria-hidden="true"></i>
                                    Cambiar contraseña
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item ml-4">
                        <div class="row">
                            <div class="col-md-3 text-md-left d-flex align-items-center">
                                <p>Contraseña:</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <span style="font-weight: 300" id="cliente-contrasena">********</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop
