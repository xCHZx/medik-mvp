@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <!-- ESPACIO ARRIBA -->
@stop

@section('content')
<div class="container mt-5">
    <div class="card">
        <form method="POST" action="{{ route('flows.store') }}">
            @csrf
            <div class="card-header row col-12 border-none mt-3">
                <h1 class="card-title col-6 text-black">Creación de flujo</h1>
                <div class="text-right col-6 mr-0">
                    <button type="submit" class="btn btnmdk-confirm btnmdk-hover mr-2 col-4">Guardar</button>
                    <a href="{{ route('flows.index') }}" class="btn btnmdk-cancel btnmdk-hover col-4">Cancelar</a>
                </div>
            </div>
            
            <div class="card-body">
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
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Escribe el nombre de tu flujo (opcional)">
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
                                    <input type="text" class="form-control" id="facebookLink" name="facebookUrl" placeholder="Escribe enlace">
                                </div>
                                <div class="form-group col-5 offset-1">
                                    <label for="googleLink">
                                        <i class="fab fa-google"></i>
                                        Google
                                    </label>
                                    <input type="text" class="form-control" id="googleLink" name="googleUrl" placeholder="Escribe enlace">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Result window -->
                    <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab">
                        <div class="card cardmdk flex-row justify-content-around col-12 mt-1 mb-3 mx-0">
                            <div class="card col-5 my-2">
                                <div class="card-header pl-1">
                                    <p class="fs-6 text-left fw-medium">Mensaje Principal</p>
                                </div>
                                <div class="card-body p-2 col-12" style="height: 200px; background-color: #E5DCD5;">                                
                                    <div class="mb-4 p-3 col-10 text-left text-black" style="background-color: #FAFAFA; border-radius: 7px">
                                        <div class="p-2 text-white" style="background-color: #166ECD; border-radius: 7px">
                                            <p class="text-left">medik</p>
                                        </div>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    </div>
                                </div>
                            </div>
                            <div class="card col-5 my-2">
                                <div class="card-header pl-1">
                                    <p class="fs-6 text-left fw-medium">Encuesta</p>
                                </div>
                                <div style="width: 100%; height: 200px; background-color: #E5DCD5;">                                
                                    <div class="p-3 row col-12" style="height: 80%">
                                      <p class="mx-1 my-1 p-3 col-10 text-left" style="background-color: #FAFAFA; border-radius: 7px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                const objetivoSeleccionado = $('input[type="radio"]:checked').attr('name');
                const descripcion = obtenerDescripcion(objetivoSeleccionado);
                $('#texto-descripcion').text(descripcion);
                $('#descripcion-objetivo').show();
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
        });
    </script>
@stop