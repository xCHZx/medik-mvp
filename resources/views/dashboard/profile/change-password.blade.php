@extends('adminlte::page')

@section('title', 'Mi Cuenta')

@section('content_header')
    <div class="mt-3">
        <h1 class="text-center"><b>Edición</b> de Seguridad</h1>
    </div>
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

    <div class="container my-2 px-0 mx-1 flex justify-center">
        <div class="card" style="width: 40rem;">
            <div class="card-body">
                <form id="cambiar-contrasena-form" action="{{ route('profile.updatePassword') }}" method="post">
                    @csrf
                    <div class="form-group mt-2.5">
                        <label for="currentPassword">Contraseña Actual</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Nueva Contraseña</label>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un dígito" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Confirmar Nueva Contraseña</label>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
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

