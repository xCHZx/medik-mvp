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
                ).then(() => {
                    location.reload(); // Necesario porque sino se bloquea botones
                });
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
                ).then(() => {
                    location.reload(); // Necesario porque sino se bloquea botones
                });
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
                }).then(() => {
                    location.reload(); // Necesario porque sino se bloquea botones
                });
            </script>   
        @stop  
    @endif

    @section('js')
        <script>
            function editarNombre() {
                Swal.fire({
                    title: 'Editar Nombre Completo',
                    html: `
                        <form id="editar-nombre-form" method="post" action="{{ route('profile.update') }}">
                            @csrf
                            <div class="form-group">
                                <label for="firstName">Nombre</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{ old('firstName', $user->firstName) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Apellidos</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{ old('lastName', $user->lastName) }}" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Actualizar Nombre Completo',
                    preConfirm: () => {
                        const form = document.getElementById('editar-nombre-form');
                        if (!form.checkValidity()) {
                            Swal.showValidationMessage('Por favor, completa todos los campos.');
                        } else {
                            form.submit();
                        }
                    },
                });
            }

            function editarCorreo() {
                Swal.fire({
                    title: 'Editar Correo Electrónico',
                    html: `
                        <form id="editar-correo-form" method="post" action="{{ route('profile.update') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Actualizar Correo Electrónico',
                    preConfirm: () => {
                        const form = document.getElementById('editar-correo-form');
                        if (!form.checkValidity()) {
                            Swal.showValidationMessage('Por favor, completa todos los campos.');
                        } else {
                            form.submit();
                        }
                    },
                });
            }

            function editarTelefono() {
                Swal.fire({
                    title: 'Editar Número de Celular',
                    html: `
                        <form id="editar-telefono-form" method="post" action="{{ route('profile.update') }}">
                            @csrf
                            <div class="form-group">
                                <label for="phone">Número de Celular</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Actualizar Número de Celular',
                    preConfirm: () => {
                        const form = document.getElementById('editar-telefono-form');
                        if (!form.checkValidity()) {
                            Swal.showValidationMessage('Por favor, completa todos los campos.');
                        } else {
                            form.submit();
                        }
                    },
                });
            }

            function cambiarContrasena() {
                Swal.fire({
                    title: 'Cambiar Contraseña',
                    html: `
                        <form id="cambiar-contrasena-form" action="{{ route('profile.updatePassword') }}" method="post">
                            @csrf
                            <div class="form-group">
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
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Actualizar Contraseña',
                    preConfirm: () => {
                        const newPassword = document.getElementById('newPassword').value;
                        const confirmNewPassword = document.getElementById('confirmNewPassword').value;
                        const form = document.getElementById('cambiar-contrasena-form');

                        if (newPassword === '' || confirmNewPassword === '' || !form.checkValidity()) {
                            Swal.showValidationMessage('Por favor, complete todos los campos correctamente.');
                        } else if (newPassword !== confirmNewPassword) {
                            Swal.showValidationMessage('Las contraseñas no coinciden.');
                        } else {
                            // Envía el formulario si pasa la validación
                            form.submit();
                        }
                    },
                });
            }
        </script>
    @endsection

    <div class="container my-4 px-4 mx-1">
        <div class="card">
            <div class="card-body">
                <div class="card-header flex justify-content-center border-bottom border-success bg-green-50">
                    <h1 class="card-title text-center" style="font-weight: 600">Información de la Cuenta</h1>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item border-bottom border-secondary">
                        <div class="row mt-3">
                            <h2 class="card-subtitle text-center" style="font-weight: 500">Datos del perfil</h2> 
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
                            <div class="col-md-3">
                                <button class="btn btn-outline-info btn-sm" onclick="editarNombre()">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                    Editar
                                </button>
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
                            <div class="col-md-3">
                                <button class="btn btn-outline-info btn-sm" onclick="editarCorreo()">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                    Editar
                                </button>
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
                            <div class="col-md-3">
                                <button class="btn btn-outline-info btn-sm" onclick="editarTelefono()">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                    Editar
                                </button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border-bottom border-secondary">
                        <div class="row mt-3">
                            <h2 class="card-subtitle text-center" style="font-weight: 500">Seguridad</h2> 
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
                            <div class="col-md-3">
                                <button class="btn btn-outline-info btn-sm" onclick="cambiarContrasena()">
                                    <i class="fas fa-user-lock" aria-hidden="true"></i>
                                    Cambiar
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!--

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

    -->
    
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
  
    
@stop

