@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <h1>Hola {{$user["firstName"]}}</h1>

    @if($status)
        <h2 class="mt-3 mb-2">Bienvenido al panel de administración de <b>medik</b></h2>
    @else
        <h1 class="mt-4">Actualmente <b>no</b> tienes una suscripción activa</h1>
        <h2 class="mt-3 mb-3">Para utilizar la plataforma, inicia tu suscripción👇</h2>
    @endif

@stop

@section('content')
    @if($status)
        <div class="mt-0 mb-4">
            <h1 class="text-xl">Este es el <b>resumen</b> de tu negocio:</h1>
        </div>
    @else
    <div class="card">
        <div class="card-body">
            <h1>Para empezar una suscripción conoce nuestros planes</h1>
            <div class="mt-4 d-none d-sm-flex">
                <a href="{{route('subscription.index')}}" role="button" class="px-3 py-2 mdkbtn-success">Ir a los planes</a>
            </div>
            <!-- Mobile -->
            <div class="mt-4 d-block d-sm-none">
                <a href="{{route('subscription.index')}}" role="button" class="d-flex w-full px-3 py-2 mdkbtn-success">
                    <p class="text-center w-full">Ir a los planes</p>
                </a>
            </div>
        </div>
    </div>
    @endif

    @if($activeBusiness)
        <div class="row">
            <div class="col-md-12">
                {{-- @if(request()->has('status') && request()->status === 'limit') --}}
                    <section id="messageLimit">
                        <div class="card rounded-xl" style="background-color: #FBF3D7">
                            <div class="card-body">
                                <h3 class="text-red font-semibold text-xl">Se ha alcanzado el límite de 400 mensajes</h3>
                                <p class="font-medium my-2">Ha alcanzado el límite de 400 mensajes automatizados en la cuenta correspondiente a su servicio. Por favor, no dude en contactarnos para encontrar la mejor solución posible.</p>
                                <a href="#" class="btn mdkbtn-primary sm:w-1/2 md:w-1/4">Contactar con Soporte</a>
                            </div>
                        </div>
                    </section>
                {{-- @endif --}}
            </div>

            <div class="col-md-7">
                <section id="resume" class="flex mdkflex-wrap gap-3 md:flex-row md:flex-nowrap lg:flex-nowrap" >
                    <div class="card md:basis-1/3 basis-full h-44" style="background: #FFEFE7">
                        <div class="card-body text-sky-950 flex flex-col justify-between py-3">
                            <h3 class="font-medium text-lg">Nuevas visitas</h3>
                            <p class="card-text text-6xl">{{count($currentMonthVisits)}}</p> <!--Aquí cambiar-->
                            <a href="#" class="text-base" style="color: #1EDDFF">Último mes</a>
                        </div>
                    </div>
                    <div class="card md:basis-1/3 basis-full h-44" style="background: #E8F0FB">
                        <div class="card-body text-sky-950 flex flex-col justify-between py-3">
                            <h3 class="font-medium text-lg">Opiniones Positivas</h3>
                            <p class="card-text text-6xl">{{count($goodReviewsLastMonth)}}</p>
                            <a href="#" class="text-base" style="color: #3786F1">Último mes</a>
                        </div>
                    </div>
                    <div class="card md:basis-1/3 basis-full h-44" style="background: #FDEBF9">
                        <div class="card-body text-sky-950 flex flex-col justify-between py-3">
                            <h3 class="font-medium text-lg">Opiniones Negativas</h3>
                            <p class="card-text text-6xl">{{count($badReviewsLastMonth)}}</p>
                            <a href="#" class="text-base" style="color: #EE61CF">Último mes</a>
                        </div>
                    </div>
                </section>

                <section id="graphs" class="mt-1 d-flex gap-4" >
                    <div class="card basis-1/2">
                        <article class="card-body">
                            <h3 class="text-sky-950 font-medium text-lg">Total Visitas</h3>
                            <div class="d-flex justify-between">
                                <div class="column">
                                    <p class="card-text text-6xl">{{count($allVisits)}}</p>
                                    {{-- <p class="text-sm text-gray-500">120 ♂️<br> 96 ♀️</p> --}}
                                </div>
                                <div class="column">
                                    {{-- <div>IMAGEN</div> --}}
                                    <div class="p-1 rounded-md w-32" style="background: #FFEFE7;">
                                        <p class="text-xs">+{{$lastMonthVisitsVariation}}% desde el mes pasado</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="card basis-1/2">
                        <article class="card-body">
                            <h3 class="text-sky-950 font-medium text-lg">Total Opiniones</h3>
                            <div class="d-flex justify-between">
                                <div class="column">
                                    <p class="card-text text-6xl">{{count($allReviews)}}</p>
                                    <p class="text-sm  text-gray-500">{{count($goodReviews)}} Positivas<br> {{count($badReviews)}} Negativas</p>
                                </div>
                                <div class="column">
                                    {{-- <div>IMAGEN</div> --}}
                                    <div class="p-1 rounded-md w-32" style="background: #FFEFE7;">
                                        <p class="text-xs">+{{$lastMonthReviewsVariation}}% desde el mes pasado</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>

                <section id="reviews" class="mt-1 d-flex gap-4">
                    <article class="card w-full">
                        <div class="card-body gap-3 pb-0">
                            <p class="font-medium text-sky-950 text-lg mb-3.5">Últimas Opiniones</p>
                            @if(count($lastReviews) > 0)
                                @foreach ($lastReviews as $review)
                                    <div class="card-in-card w-full flex flex-row py-1 px-3">
                                        <div class="basis-4/5">
                                            <h3 class="text-lg my-1.5">{{$review->comment}}</h3>
                                            <p class="text-xs text-muted mb-2">{{$review->created_at}}</p>
                                        </div>
                                        <div class="basis-1/5 flex items-center">
                                            <input
                                                name="rating"
                                                class="rating mt-2"
                                                max="5"
                                                style="--value:{{$review->rating}}; --starsize: 1.5rem;"
                                                type="range"
                                                disabled
                                            >
                                        </div>
                                    </div>
                                @endforeach
                                <div class="card-footer border-t-2 rounded-none d-flex justify-center">
                                    <a href={{route('reviews.index')}} class="w-full font-semibold text-center text-cyan-500">Ver Todas las Opiniones</a>
                                </div>
                            @else
                                <div class="card-in-card w-full text-center font-medium">Aún no se han generado opiniones para tu negocio</div>
                            @endif
                        </div>
                    </article>
                </section>
            </div>
            <div class="col-md-5">
                <section id="main-lateral" class="d-flex flex-col gap-x-2 flex-grow h-full">
                    <article class="card bg-slate-900  text-white basis-1/2">
                        <div class="card-header rounded-t-3xl font-medium text-lg p-2.5 pl-4" style="background: #1B204A">
                            Flujo Activo
                        </div>
                        <div class="card-body px-4">
                            <p class="pb-2 text-gray-400">Fecha de creación: {{$activeFlow->created_at}}</p>
                            <h3 class="pb-2 font-medium text-lg">{{$activeFlow->name}}</h3>
                            <p class="pb-2 text-sm text-gray-400">Obejtivo: {{$activeFlow->objective}}</p>
                            <p id="objetive_description" class="pb-3 text-gray-300"></p>
                            <div class="flex justify-center">
                                <a href={{route('flows.index')}} class="btn mdkbtn-primary p-2 mt-2 w-2/3 text-center font-medium">Ver más</a>
                            </div>
                            
                        </div>
                    </article>
                    <article class="card basis-1/2">
                        <div class="card-body text-sky-950">
                            <h6 class="font-medium text-lg">Negocio Activo</h6>
                            <p class="my-4 font-medium text-2xl card-text">{{$activeBusiness->name}}</p>
                            <label class="d-flex flex-column justify-content-center align-items-center text-7xl">
                                {{number_format($activeBusiness->averageRating, 1)}}
                                <input
                                name="rating"
                                class="rating mt-2"
                                max="5"
                                style="--value:{{$activeBusiness->averageRating}}; --starsize: 4rem;"
                                type="range"
                                disabled
                            >
                            </label>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    @endif
@stop

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const flowObjetive = '{{$activeFlow->objective}}';

            function objetiveDescription(flowObjetive) {
                switch (flowObjetive) {
                    case 'Calidad de la atención médica':
                        return "Evalúa cómo tus pacientes perciben la calidad de la atención médica proporcionada, incluida la efectividad de los tratamientos y la gestión de las condiciones de salud.";
                    case 'Accesibilidad y tiempo de espera':
                        return "Evalúa cómo tus pacientes perciben la forma con la que pueden acceder a tus servicios médicos y el tiempo de espera para recibir los mismos.";
                    case 'Comunicación médico-paciente':
                        return "Evalúa cómo tus pacientes perciben la eficacia de la comunicación que tu o tu personal tiene con ellos, así como la claridad y comprensión de la información proporcionada.";
                    case 'Satisfacción general':
                        return "Evalúa cómo tus pacientes perciben la atención que les brindas en tu servicio y la calidad de los mismos, este objetivo abarca los 3 puntos anteriores y es la opción por si no sabes cual escoger o no buscas abordar un punto en particular.";
                    default:
                        return "Evalúa un aspecto personalizado por ti de la calidad de tu servicio";
                }
            }

            document.getElementById('objetive_description').textContent = objetiveDescription(flowObjetive);
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

