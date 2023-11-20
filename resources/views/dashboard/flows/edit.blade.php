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
                <h1 class="card-title col-6 text-black"><b>Edición</b> de flujos</h1>
                <div class="text-right col-6 mr-0">
                    <button type="submit" class="btn mdkbtn-success mr-2 col-5">Guardar Cambios</button>
                    <a href="{{ route('flows.index') }}" class="btn mdkbtn-danger col-4">Cancelar</a>
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
                        <div class="card mdkTabCard mt-0.5 mb-3 mx-0">
                            <div class="card-header border-none text-black">
                                Escoge uno de los siguientes objetivos para definir qué aspecto deseas evaluar:
                            </div>

                            <div class="flex justify-content-between col-12">
                                <div class="card-body ml-3 col-5">
                                    <div class="form-check mb-4">
                                        <input type="hidden" value="{{$flow->objetivo}}" id="objetivoflow">
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
                                <div id="descripcion-objetivo" class="mdkTabCard-display my-3 mr-3 col-6">
                                    <div class="card-body ml-3">
                                        <p id="texto-descripcion" class="text-body-secondary"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information window -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="card mdkTabCard mt-0.5 mb-3 mx-0">
                            <div class="card-header border-none">
                                Démosle un nombre a tu flujo para poder identificarlo, si no asignas un nombre, no te preocupes, le asignaremos uno por ti.
                            </div>
                            <div class="card-body row col-12">
                                <div class="form-group col-7">
                                    <input type="text" class="form-control" id="flowName" name="name" value= "{{$flow->name }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review window -->
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        <div class="card mdkTabCard mt-0.5 mb-3 mx-0">
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
                        <div class="card mdkTabCard flex-row justify-content-around col-12 mt-1 mb-3 mx-0">
                            <div class="col-5 my-2">
                                <div class="card-header pl-1 border-0">
                                    <p class="fs-6 text-left fw-medium">Mensaje Principal</p>
                                </div>
                                <div class="card-body p-2 mb-2 wss-bg">                                
                                    <div class="mb-4 p-3 col-10 bg-white rounded-lg text-left text-black">
                                        <div class="p-2 text-white rounded-lg bg-business-image">
                                            <span class="text-left text-white fw-bolder">
                                                {{$businessName}}
                                            </span>

                                            <div class="d-flex justify-content-end align-items-end">
                                                <!-- Logo Medik -->
                                                <x-logo-full fill-1="#FFF" fill-2="#FFF" class="mt-2" width="50" height="25"></x-logo-full>
                                            </div>
                                        </div>
                                        <div class="mt-2 fs-6 mb-1">
                                            Hola! 😀<br class="my-0 py-0">
                                            <br class="my-0 py-0">
                                            Te registraste para participar en nuestra encuesta de <p id="whatsappMainPreview" class="my-0 py-0 d-inline"></p>. 
                                            ¿Deseas contestar un breve formulario y ayudarnos a evaluar la calidad de nuestro servicio? 🙏
                                        </div>
                                        <p class="text-gray-500 fs-7 mt-0">¿No te interesa? Toca "Detener promociones"</p>
                                        <ul class="list-group list-group-flush border-0 mt-2">
                                            <li class="list-group-item text-center text-primary border-top p-1">
                                                <i class="fas fa-external-link-alt"></i>
                                                Participar en encuesta
                                            </li>
                                            <li class="list-group-item text-center text-primary p-1">
                                                <i class="fas fa-reply"></i>
                                                Detener promociones
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5 my-2">
                                <div class="card-header pl-1 border-0">
                                    <p class="fs-6 text-left fw-medium">Encuesta</p>
                                </div>
                                <div class="card-body p-2 mb-2 wss-bg">                                
                                    <div class="mb-4 p-3 col-10 bg-white rounded-lg text-left text-black">
                                        <div class="p-2 text-white rounded-lg bg-business-image">
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

        <div class="d-flex justify-center mb-3">
            <button class="mdkbtn-info py-2 w-32" id="reverse-btn">Anterior</button>
            <button class="mdkbtn-primary py-2 ml-3 w-32" id="forward-btn">Siguiente</button>
        </div>

        <div class="container d-flex flex-column justify-center px-4">
            <div id="info1-container" class="card flex-row justify-content-between bg-gray-300">
                <div class="d-flex align-items-center mx-3">
                    <i class="fas fa-question-circle bg-primaryquestion"></i>
                </div>
                <div class="text-black text-left my-2 pr-4">
                    Cuando tus pacientes escaneen tu código QR y acepten recibir mensajes tuyos , recibirán un primer mensaje en la aplicación de mensajería Whatsapp para solicitarles que califiquen el objetivo que has seleccionado.
                </div>
                <div class="d-flex align-self-start mt-1 mr-1 p-0">
                    <i id="info1" class="fas fa-times-circle bg-cancel cursor-pointer"></i>
                </div>
            </div>

            <div id="info2-container" class="card flex-row justify-content-between bg-gray-300">
                <div class="d-flex align-items-center mx-3">
                    <i class="fas fa-question-circle bg-primaryquestion"></i>
                </div>
                <div class="text-black text-left my-2 pr-4">
                    Una vez que tus pacientes acepten en whatsapp calificar a tu negocio serán redirigidos a una página web donde les explicaremos el objetivo que quieres calificar y cómo pueden hacerlo.
                </div>
                <div class="d-flex align-self-start mt-1 mr-1 p-0">
                    <i id="info2" class="fas fa-times-circle bg-cancel cursor-pointer"></i>
                </div>
            </div> 
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            //Recupera y selecciona el objetivo del flujo
            var currentSelectedObjetive = '{{$flow->objetivo}}';
            var objetivesRadios = document.querySelectorAll('input[name="objetivo"]');
            objetivesRadios.forEach(function(radio) {
                if (radio.value === currentSelectedObjetive) {
                    radio.checked = true;
                }
            });
            
            // Muestra descripción
            $('input[type="radio"]:checked', function () {
                const selectedObjetive = $('input[type="radio"]:checked').attr('id');
                const valueSelectedObjetive = $('input[type="radio"]:checked').attr('value');
                const description = showDescription(selectedObjetive);
                $('#texto-descripcion').text(description);
                $('#descripcion-objetivo').show();
                $('#whatsappMainPreview').text(valueSelectedObjetive);
            });

            $('input[type="radio"]').on('click', function () {
                // Actualiza el valor del objetivo seleccionado
                const businessName = '{{$businessName}}';
                const valueSelectedObjetive = $('input[type="radio"]:checked').attr('value');
                const defaultFlowName = valueSelectedObjetive;
                $('#flowName').val(defaultFlowName);
            });

            // Cambia la descripción según el objetivo seleccionado
            function showDescription(selectedObjetive) {
                switch (selectedObjetive) {
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

            // Función para retroceder a la pestaña anterior
            function avanzarPestana() {
                var $activeTab = $('.nav-tabs .nav-link.active');
                var $nextTab = $activeTab.parent().next().children('a');

                if ($nextTab.length > 0) {
                    $nextTab.tab('show');
                }
            };

            // Función para retroceder a la pestaña anterior
            function retrocederPestana() {
                var $activeTab = $('.nav-tabs .nav-link.active');
                var $prevTab = $activeTab.parent().prev().children('a');

                if ($prevTab.length > 0) {
                    $prevTab.tab('show');
                }
            };

            // Evento al hacer clic en el botón de avanzar
            $('#forward-btn').on('click', function () {
                avanzarPestana();
            });

            // Evento al hacer clic en el botón de retroceder
            $('#reverse-btn').on('click', function () {
                retrocederPestana();
            });

            //Oculta instrucciones
            document.getElementById("info1").addEventListener("click", function() {
                document.getElementById("info1-container").hidden = true;
            });

            document.getElementById("info2").addEventListener("click", function() {
                document.getElementById("info2-container").hidden = true;
            });
        });
    </script>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop
