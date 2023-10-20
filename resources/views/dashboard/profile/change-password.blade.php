@extends('adminlte::page')

@section('title', 'Mi Cuenta')

@section('content_header')
<!-- ESPACIO ARRIBA -->
@stop

@section('content')
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
    @elseif (session('status') === 'password-error')
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

    <div class="container my-4 px-4 mx-1 flex justify-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <div class="card-header flex justify-content-center border-bottom border-danger bg-red-50">
                    <h1 class="card-title text-center" style="font-weight: 600">Edición de Seguridad</h1>
                </div>
                <form id="cambiar-contrasena-form" action="{{ route('profile.updatePassword') }}" method="post">
                    @csrf
                    <div class="form-group mt-2.5">
                        <label for="currentPassword">Contraseña Actual</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
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

