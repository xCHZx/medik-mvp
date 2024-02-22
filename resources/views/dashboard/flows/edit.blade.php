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
                                        <input type="hidden" value="{{$flow->objective}}" id="objetivoflow">
                                        <input class="form-check-input" type="radio" name="objective" id="obj1" value="Calidad de la atención médica">
                                        <label class="form-check-label" for="obj1">
                                            Calidad de la atención médica
                                        </label>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="radio" name="objective" id="obj2" value="Accesibilidad y tiempo de espera">
                                        <label class="form-check-label" for="obj2">
                                            Accesibilidad y tiempo de espera
                                        </label>
                                    </div>
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="radio" name="objective" id="obj3" value="Comunicación médico-paciente">
                                        <label class="form-check-label" for="obj3">
                                            Comunicación médico-paciente
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="objective" id="obj4" value="Satisfacción general">
                                        <label class="form-check-label" for="obj4">
                                            Satisfacción general
                                        </label>
                                    </div>
                                </div>

                                <!-- Dinamic description -->
                                <div id="descripcion-objetivo" class="descriptionCard my-3 mr-3 col-6 invisible">
                                    <div class="card-body ml-3 pl-0 pr-3 py-4">
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
                        <div class="card mdkTabCard flex-row justify-around gap-4 mt-1 mb-3 mx-0 px-4">
                            <div class="col-6 my-2">
                                <div class="card-header pl-1 border-0">
                                    <p class="fs-6 text-left font-semibold">Mensaje Principal</p>
                                </div>
                                <div class="card-body p-2 mb-4 wss-bg min-h-[85%]">                                
                                    <div class="mb-0 px-3 pt-3 pb-0 col-10 bg-white rounded-xl text-left text-black">
                                        <div class="p-3 text-white rounded-xl bg-business-image">
                                            <span class="text-left text-white font-bold">
                                                {{$businessName}}
                                            </span>

                                            <div class="d-flex justify-content-end align-items-end">
                                                <!-- Logo Medik -->
                                                <x-logo-full fill-1="#FFF" fill-2="#FFF" class="mt-2" width="60" height="30"/>
                                            </div>
                                        </div>
                                        <div class="mt-2 fs-6 mb-1">
                                            ¡Hola! ¿Cómo estuvo tu experiencia con nuestro servicio? Nos encantaria conocer tu opinión.😊<br class="my-0 py-0">
                                            <br class="my-0 py-0">
                                            {{$businessName}} te invita a calificar su servicio. ¡Tu opinión es muy importante para nosotros!🌟
                                        </div>
                                        <ul class="list-group list-group-flush border-0 mt-3 mb-0">
                                            <li class="list-group-item text-center text-primary border-top px-2 pt-2 pb-0 mb-2 cursor-pointer">
                                                <i class="fas fa-external-link-alt"></i>
                                                Calificar Servicio
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 my-2">
                                <div class="card-header pl-1 border-0">
                                    <p class="fs-6 text-left font-semibold">Encuesta</p>
                                </div>
                                <div class="card-body fs-6 py-3 px-4 rounded-xl min-h-[85%]" style="background-color: #F5F4F4">                                
                                    <p>
                                        Queremos saber cómo fue tu experiencia con nosotros.<br class="my-0 py-0">
                                        <br class="my-0 py-0">
                                        <span id="alias-text">¡Gracias por tu ayuda!</span>
                                    </p>
                                    <div class="d-flex justify-center my-2">
                                        <input
                                            class="rating cursor-pointer"
                                            max="5"
                                            style="--value:5; --starsize: 1.5rem; background-color: #F5F4F4"
                                            type="range"
                                            value="5"
                                            disabled
                                        >
                                    </div>
                                    <p>
                                        Tu opinión es importante para mejorar nuestro servicio.
                                    </p>
                                    <textarea name="comment" id="comment" class="form-control mdkTextArea my-1" rows="4" disabled></textarea>
                                    <div class="mdkbtn-success w-full py-1 mt-2 text-center cursor-pointer">Enviar</div>
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
            var currentSelectedObjetive = '{{$flow->objective}}';
            var objetivesRadios = document.querySelectorAll('input[name="objective"]');
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
                const alias = getAlias(selectedObjetive);
                $('#texto-descripcion').text(description);
                $('#descripcion-objetivo').removeClass('invisible');
                $('#alias-text').text(`${alias} `);
            });

            $('input[type="radio"]').on('change', function () {
                // Actualiza el valor del objetivo seleccionado
                const valueSelectedObjetive = $('input[type="radio"]:checked').attr('value');
                const selectedObjetive = $('input[type="radio"]:checked').attr('id');
                const defaultFlowName = valueSelectedObjetive;
                const description = showDescription(selectedObjetive);
                const alias = getAlias(selectedObjetive);
                $('#texto-descripcion').text(description);
                $('#flowName').val(defaultFlowName);
                $('#alias-text').text(`${alias} `);
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
            };

            function getAlias(selectedObjetive) {
                const aliases = {!! json_encode($aliases) !!};
                
                switch (selectedObjetive) {
                    case 'obj1':
                        return aliases['Calidad de la atención médica'];
                    case 'obj2':
                        return aliases['Accesibilidad y tiempo de espera'];
                    case 'obj3':
                        return aliases['Comunicación médico-paciente'];
                    case 'obj4':
                        return aliases['Satisfacción general'];
                    default:
                        return "Selecciona un alias válido";
                }
            };

            // Deselecciona los otros radio buttons
            $('input[type="radio"]').on('click', function () {
                $('input[type="radio"]').not(this).prop('checked', false);
            });

            function actualizarBotonesPestana() {
                var $activeTab = $('.nav-tabs .nav-link.active');
                var tabIndex = $activeTab.parent().index();

                if (tabIndex === 0) {
                    $('#reverse-btn').prop('disabled', true);
                } else {
                    $('#reverse-btn').prop('disabled', false);
                }

                if (tabIndex === $('.nav-tabs .nav-item').length - 1) {
                    $('#forward-btn').prop('disabled', true);
                } else {
                    $('#forward-btn').prop('disabled', false);
                }
            }

            function cambiarPestana(next) {
                var $activeTab = $('.nav-tabs .nav-link.active');
                var $tabs = $('.nav-tabs .nav-item');
                var index = $activeTab.parent().index();

                if (next && index < $tabs.length - 1) {
                    $tabs.eq(index + 1).children('a').tab('show');
                } else if (!next && index > 0) {
                    $tabs.eq(index - 1).children('a').tab('show');
                }

                actualizarBotonesPestana();
            }

            $('#forward-btn, #reverse-btn').on('click', function () {
                const direction = $(this).is('#forward-btn'); //Si es true avanza, sino retrocede
                cambiarPestana(direction);
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                actualizarBotonesPestana();
            });

            actualizarBotonesPestana();

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
