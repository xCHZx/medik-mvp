@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <!-- ESPACIO ARRIBA -->
@stop

@section('content')
<div class="container mt-3">
    <div class="card p-1">
      
        <form method="POST" action="{{ route('flows.update') }}">
           @csrf
           <input type="hidden" name="flowId" value="{{$flow->id}}">
            <div class="card-header row col-12 border-none mt-3 mr-0">
                <h1 class="card-title col-6 text-black">Edición de flujos</h1>
                <div class="text-right col-6 mr-0">
                    <button type="submit" class="btn btnmdk-confirm btnmdk-hover mr-2 col-5">Guardar Cambios</button>
                    <a href="{{ route('flows.index') }}" class="btn btnmdk-cancel btnmdk-hover col-4">Cancelar</a>
                    
                </div>
            </div>
            
            <div class="card-body mb-0 pb-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="objetives-tab" data-toggle="tab" href="#objetives" role="tab" aria-controls="objetives" aria-selected="true">Objetivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="false">Información</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Redes Sociales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="result-tab" data-toggle="tab" href="#result" role="tab" aria-controls="result" aria-selected="false">Resultado</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- Objetive window -->
                    <div class="tab-pane fade show active" id="objetives" role="tabpanel" aria-labelledby="objetives-tab">
                        <div class="card cardmdk mt-0.5 mb-3 mx-0">
                            <div class="card-header border-none text-black">
                                Escoge uno de los siguientes objetivos para definir qué aspecto deseas evaluar:
                            </div>

                            <div class="flex justify-content-between col-12">
                                <div class="card-body ml-3 col-5">
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="radio" name="objetivo" id="obj1" value="Calidad de la atención médica">
                                        <label class="form-check-label" for="obj1">
                                            Calidad de la atención médica
                                        </label>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="radio" name="objetivo" id="obj2" value="Accesibilidad y tiempo de espera">
                                        <label class="form-check-label" for="obj2">
                                            Accesibilidad y tiempo de espera
                                        </label>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="radio" name="objetivo" id="obj3" value="Comunicación médico-paciente">
                                        <label class="form-check-label" for="obj3">
                                            Comunicación médico-paciente
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="objetivo" id="obj4" value="Satisfacción general">
                                        <label class="form-check-label" for="obj4">
                                            Satisfacción general
                                        </label>
                                    </div>
                                </div>

                                <!-- Dinamic description -->
                                <div id="descripcion-objetivo" class="cardmdk-display my-3 mr-3 col-6">
                                    <div class="card-body ml-3">
                                        <p id="texto-descripcion" class="text-body-secondary"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information window -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="card cardmdk mt-0.5 mb-3 mx-0">
                            <div class="card-header border-none">
                                Démosle un nombre a tu flujo para poder identificarlo, si no asignas un nombre, no te preocupes, le asignaremos uno por ti.
                            </div>
                            <div class="card-body row col-12">
                                <div class="form-group col-7">
                                    <input type="text" class="form-control" id="name" name="name" value= "{{$flow->name }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review window -->
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        <div class="card cardmdk mt-0.5 mb-3 mx-0">
                            <div class="card-header border-none">    
                                Junto a los comentarios y calificaciones tus pacientes podrán ver links a tus redes sociales o a tu página web, si deseas agregarlos colocalos aquí, en caso de que no tengas ninguno puedes dejar el espacio en blanco
                            </div>
                            <div class="card-body row col-12">
                                <div class="form-group col-5">
                                    <label for="facebookLink">
                                        <i class="fab fa-facebook"></i>
                                        Facebook
                                    </label>
                                    @if($facebookLink)
                                    <input type="text" class="form-control" id="facebookLink" name="facebookUrl" placeholder="{{$facebookLink->url}}">
                                    @else
                                    <input type="text" class="form-control" id="facebookLink" name="facebookUrl" placeholder="Escribe enlace">
                                    @endif
                                </div>
                                <div class="form-group col-5 offset-1">
                                    <label for="googleLink">
                                        <i class="fab fa-google"></i>
                                        Google
                                    </label>
                                    @if($googleLink)
                                    <input type="text" class="form-control" id="googleLink" name="googleUrl" placeholder="{{$googleLink->url}}">
                                    @else
                                    <input type="text" class="form-control" id="googleLink" name="googleUrl" placeholder="Escribe enlace">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Result window -->
                    <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab">
                        <div class="card cardmdk flex-row justify-content-around col-12 mt-1 mb-3 mx-0">
                            <div class="col-5 my-2">
                                <div class="card-header pl-1 border-0">
                                    <p class="fs-6 text-left fw-medium">Mensaje Principal</p>
                                </div>
                                <div class="card-body p-2 mb-2 wss-bg">                                
                                    <div class="mb-4 p-3 col-10 bg-white rounded-lg text-left text-black">
                                        <div class="p-2 text-white rounded-lg bg-strongblue">
                                            <span class="text-left text-white fw-bolder">
                                                {{$businessName}}
                                            </span>

                                            <div class="d-flex justify-content-end align-items-end">
                                                <!-- Logo Medik -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mt-2" viewBox="0 0 716 235" width="50" height="25" style="shape-rendering:geometricPrecision;text-rendering:geometricPrecision;image-rendering:optimizeQuality;fill-rule:evenodd;clip-rule:evenodd">
                                                    <path fill="#fff" d="M601 115c10 0 14 6 13 13-1 9-8 9-17 9-8-1-10-7-9-14 2-6 5-8 13-8Z
                                                    M558.5 115.5c5.903-.258 9.737 2.409 11.5 8 .98 35.394.647 70.727-1 106-6.208 6.601-12.541 6.601-19 0-.17-2.215-.837-4.215-2-6-8.354 9.392-18.854 12.892-31.5 10.5-13.699-3.364-22.532-11.864-26.5-25.5-2.238-11.752-1.905-23.418 1-35 8.366-18.433 22.533-25.6 42.5-21.5 5.912 1.538 10.745 4.705 14.5 9.5l1-38c1.571-4.75 4.738-7.417 9.5-8Zm-34 52c16.524-.143 24.857 8.19 25 25 .194 9.773-3.473 17.606-11 23.5-11.687 4.667-20.52 1.501-26.5-9.5-4.189-12.308-2.689-23.808 4.5-34.5a48.484 48.484 0 0 1 8-4.5Z
                                                    M642.5 115.5c4.666.08 8.166 2.08 10.5 6l1 64a723.157 723.157 0 0 1 31.5-32.5c4.211-1.534 8.544-1.867 13-1 5.153 4.609 5.32 9.442.5 14.5a406.15 406.15 0 0 0-23.5 24.5l27.5 29.5c3.463 10.544-.37 15.044-11.5 13.5a22.981 22.981 0 0 1-5-2 2424.91 2424.91 0 0 0-32.5-33.5 290.664 290.664 0 0 1-2 33c-6.294 4.289-12.294 3.956-18-1-1.647-35.94-1.98-71.94-1-108 1.706-4.426 4.873-6.76 9.5-7Z
                                                    M302.5 150.5c12.657-1.581 21.991 3.086 28 14 9.531-12.233 21.865-16.4 37-12.5 10.512 4.197 16.012 12.031 16.5 23.5a675.912 675.912 0 0 1 0 52c-3.606 6.92-9.106 8.754-16.5 5.5a11.532 11.532 0 0 1-3.5-4.5 778.309 778.309 0 0 0-2-52c-1.422-5.973-5.255-8.973-11.5-9-7.892.524-13.058 4.524-15.5 12a698.417 698.417 0 0 0-2 49c-3.055 5.135-7.555 6.968-13.5 5.5-2.348-.346-4.181-1.513-5.5-3.5a693.12 693.12 0 0 1-2-51c-.655-7.321-4.655-11.321-12-12-8.421 1.085-13.754 5.751-16 14l-1 45c-1.173 5.265-4.506 7.931-10 8-6.492.274-10.158-2.726-11-9l-.5-32.5a381.129 381.129 0 0 1 1.5-37.5c4.091-3.805 8.924-4.972 14.5-3.5 4.045 2.253 5.878 5.753 5.5 10.5 4.969-6.724 11.469-10.724 19.5-12Z
                                                    M435.5 150.5c29.452-.049 43.285 14.618 41.5 44-.5 1.167-1.333 2-2.5 2.5l-54 1c2.578 13.072 10.578 19.905 24 20.5a85.482 85.482 0 0 0 25.5-7c2.873.098 4.873 1.432 6 4 1.652 5.346.152 9.513-4.5 12.5-19.413 9.272-38.413 8.606-57-2-12.096-11.625-16.596-25.792-13.5-42.5 3.911-19.08 15.411-30.08 34.5-33Zm2 15c14.028-.637 21.361 6.029 22 20-13.004.167-26.004 0-39-.5 1.671-10.161 7.338-16.661 17-19.5Z
                                                    M596.5 151.5c6.02-1.28 10.853.387 14.5 5 .667 24 .667 48 0 72-1.959 4.172-5.292 6.172-10 6-5.121-.457-8.455-3.123-10-8a1155.672 1155.672 0 0 1 0-68c.938-3.098 2.772-5.431 5.5-7Z"/>
                                                    <path fill="#fff" d="M63 .5c28.111-1.609 50.111 9.057 66 32C148.753 5.412 175.087-4.422 208 3c24.241 6.574 39.407 22.074 45.5 46.5 6.784 26.51 3.118 51.51-11 75A260.923 260.923 0 0 1 215 163c-7.179 4.282-12.679 2.782-16.5-4.5-.667-2-.667-4 0-6a370.345 370.345 0 0 0 26-38c15.407-24.48 16.407-49.481 3-75C216.127 25.367 201.294 19.2 183 21c-14.222 1.694-25.722 8.194-34.5 19.5a125.587 125.587 0 0 0-12 23c-5.333 4-10.667 4-16 0C109.808 30.078 87.308 16.578 53 23c-16.758 5.094-26.925 16.261-30.5 33.5-4.071 17.693-2.071 34.693 6 51 12.408 22.806 27.741 43.473 46 62A475.738 475.738 0 0 0 122 212c3.5 3 7.5 3 11 1a138.677 138.677 0 0 0 15.5-12.5c-5-20.5 12-32.5 28.5-27.5 15.5 7 19.5 22 10.5 34.5-6 7.5-14.927 9.421-24.5 8.5-6 4.667-12 9.333-17.8 14-13.5 8-24.5 8-36-2-36.796-27.79-67.63-60.957-92.5-99.5-20.034-32.129-21.701-65.129-5-99C23.5 11 41.557 2.238 63.2.5zm105 183c7.5-.5 14.5 5.5 10.5 15-4 6.5-14 6.5-18-1-3-7.5 2-13.5 7.5-14z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="my-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        <ul class="list-group list-group-flush border-0 mt-2">
                                            <li class="list-group-item text-center text-primary border-top p-1">
                                                <i class="fas fa-external-link-alt"></i>
                                                Aceptar
                                            </li>
                                            <li class="list-group-item text-center text-primary p-1">
                                                <i class="fas fa-external-link-alt"></i>
                                                Dejar de recibir promociones
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5 my-2">
                                <div class="card-header pl-1 border-0">
                                    <p class="fs-6 text-left fw-medium">Mensaje Principal</p>
                                </div>
                                <div class="card-body p-2 mb-2 wss-bg">                                
                                    <div class="mb-4 p-3 col-10 bg-white rounded-lg text-left text-black">
                                        <div class="p-2 text-white rounded-lg bg-strongblue">
                                            <span class="text-left text-white fw-bolder">
                                                EN DESARROLLO
                                            </span>
                                        </div>
                                        <p class="my-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div id="info1-container" class="container">
            <div class="container d-flex justify-content-center">
                <div class="card d-flex flex-row justify-content-between align-items-center bg-gray-300 rounded-lg">
                    <div class="d-flex align-items-center mx-3">
                        <i class="fas fa-question-circle bg-primaryquestion"></i>
                    </div>
                    <div class="text-black text-left my-2">
                        Cuando tus pacientes escaneen tu código QR y acepten recibir mensajes tuyos , recibirán un primer mensaje en la aplicación de mensajería Whatsapp para solicitarles que califiquen el objetivo que has seleccionado.
                    </div>
                    <div class="d-flex align-self-start mt-1 mr-1 p-0">
                        <i id="info1" class="fas fa-times-circle bg-cancel"></i>
                    </div>
                </div>
            </div>
        </div>

        <div id="info2-container" class="container">
            <div class="container d-flex justify-content-center">
                <div class="card d-flex flex-row justify-content-between align-items-center bg-gray-300 rounded-lg">
                    <div class="d-flex align-items-center mx-3">
                        <i class="fas fa-question-circle bg-primaryquestion"></i>
                    </div>
                    <div class="text-black text-left my-2">
                        Una vez que tus pacientes acepten en whatsapp calificar a tu negocio serán redirigidos a una página web donde les explicaremos el objetivo que quieres calificar y cómo pueden hacerlo.
                    </div>
                    <div class="d-flex align-self-start mt-1 mr-1 p-0">
                        <i id="info2" class="fas fa-times-circle bg-cancel"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        $(document).ready(function () {
            // Muestra descripción
            $('input[type="radio"]').on('change', function () {
                const objetivoSeleccionado = $('input[type="radio"]:checked').attr('id');
                const nombreObjetivoSeleccionado = $('input[type="radio"]:checked').attr('value');
                const descripcion = obtenerDescripcion(objetivoSeleccionado);
                $('#texto-descripcion').text(descripcion);
                $('#descripcion-objetivo').show();

                // Actualiza el valor del objetivo seleccionado
                const businessName = '{{$businessName}}';
                const nombreFlujo = nombreObjetivoSeleccionado + " - " + businessName;
                $('#name').val(nombreFlujo);
            });

            // Cambia la descripción según el objetivo seleccionado
            function obtenerDescripcion(objetivoSeleccionado) {
                switch (objetivoSeleccionado) {
                    case 'obj1':
                        return "Escoge este objetivo si deseas evaluar cómo tus pacientes perciben la calidad de la atención médica proporcionada, incluida la efectividad de los tratamientos y la gestión de las condiciones de salud.";
                    case 'obj2':
                        return "Escoge este objetivo si deseas evaluar como tus pacientes perciben la forma con la que pueden acceder a tus servicios médicos y el tiempo de espera para recibir los mismos.";
                    case 'obj3':
                        return "Escoge este objetivo si deseas evaluar como tus pacientes perciben la eficacia de la comunicación que tu o tu personal tiene con ellos, así como la claridad y comprensión de la información proporcionada.";
                    case 'obj4':
                        return "Escoge este objetivo si deseas evaluar como tus pacientes percibe la atención que les brindas en tu servicio y la calidad de los mismos , este objetivo abarca los 3 puntos anteriores y es la opción por si no sabes cual escoger o no buscas abordar un punto en particular.";
                    default:
                        return "Selecciona un objetivo válido";
                }
            }

            // Deselecciona los otros radio buttons
            $('input[type="radio"]').on('click', function () {
                $('input[type="radio"]').not(this).prop('checked', false);
            });

            //Oculta instrucciones
            document.getElementById("info1").addEventListener("click", function() {
                document.getElementById("info1-container").style.display = "none";
            });

            document.getElementById("info2").addEventListener("click", function() {
                document.getElementById("info2-container").style.display = "none";
            });
        });
    </script>
@stop