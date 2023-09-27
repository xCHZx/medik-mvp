@extends('adminlte::page')

@section('title', 'Mi Cuenta')

@section('content_header')
    <h1>Datos de tu cuenta</h1>
@stop

@section('content')
   @if(session('status') === 'profile-updated')
       @section('js')
          <script>
              Swal.fire(
                   'LIsto!',
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
                         'LIsto!',
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
    

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="container my-4 px-4 mx-auto">
        <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
           <h2>Edita tu perfil o revisa tus datos desde este formulario.</h2>
            <form method="post" action="{{ route('profile.update') }}">
                @csrf

                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label class="form-label" for="firstName" >Nombre</label>
                    <input class="form-control" type="text" id="firstName" name="firstName" value="{{old('firstName',$user->firstName)}}">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label class="form-label" for="laststName" >Apellido</label>
                    <input class="form-control" type="text" id="lastName" name="lastName" value="{{old('lastName',$user->lastName)}}">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label for="email"  class="form-label">Correo</label>
                    <input class="form-control" type="email" id="email" name="email" value="{{old('email',$user->email)}}">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                    <label for="phone"   class="form-label">Telefono</label>
                    <input class="form-control" type="text" id="phone" name="phone" value="{{old('phone',$user->phone)}}">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-outline-info">Editar</button>
                </div>
                
            
            </form>

        </div>
        
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
            <p>Actualizar  contraseña</p>
            <form action="{{ route('profile.updatePassword') }}" method="post">
               @csrf
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                <label for="currentPassword" class="form-label" >Contraseña Actual</label>
                <input  class="form-control" type="password" id="currentPassword" name="currentPassword" value="{{ old('currentPassword') }}">
            </div>
            <div  class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
                <label for="newPassword" class="form-label" >Contraseña Nueva</label>
                <input class="form-control" type="password" id="newPassword" name="newPassword" value="{{ old('newPassword') }}">
            </div>
            <div class="mb-3">
                <button type="submit" class=" btn btn-outline-info">Actualizar</button>
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

