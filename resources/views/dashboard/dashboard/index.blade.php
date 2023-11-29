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
            <div class="col-md-8">
                <section id="resume" class="d-flex gap-4" >
                    <div class="card basis-1/3" style="background: #FFEFE7">
                        <div class="card-body text-sky-950">
                            <h3 class="font-medium text-lg">Nuevas visitas</h3>
                            <p class="card-text text-6xl">{{count($currentMonthVisits)}}</p> <!--Aquí cambiar-->
                            <a href="#" class="text-base-" style="color: #1EDDFF">Último mes</a>
                        </div>
                    </div>
                    <div class="card basis-1/3" style="background: #E8F0FB">
                        <div class="card-body text-sky-950">
                            <h3 class="font-medium text-lg">Opiniones Positivas</h3>
                            <p class="card-text text-6xl">{{count($goodReviewsLastMonth)}}</p>
                            <a href="#" class="text-base" style="color: #3786F1">Último mes</a>
                        </div>
                    </div>
                    <div class="card basis-1/3" style="background: #FDEBF9">
                        <div class="card-body text-sky-950">
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
                        <div class="card-body gap-3">
                            @foreach ($lastReviews as $review)
                            <div class="card w-full flex flex-row py-1 px-3">
                                <div class="basis-4/5">
                                    <h3 class="text-lg text-sky-950">{{$review->comment}}</h3>
                                    <p class="text-xs text-muted">{{$review->created_at}}</p>
                                </div>
                                <div class="basis-1/5">
                                    <input
                                        name="rating"
                                        class="rating mt-2"
                                        max="5"
                                        {{-- oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" --}}
                                        {{-- style="--value:{{number_format($activeBusiness->averageRating, 1)}}; --starsize: 2rem" --}}
                                        style="--value:{{$review->rating}}; --starsize: 1.5rem; --fill: #D29D53"
                                        {{-- style="--value:{{$activeBusiness->averageRating}}; --starsize: 1.5rem; --fill: #D29D53" --}}
                                        type="range"
                                        disabled
                                    >
                                </div>
                            </div>
                            @endforeach
                            <a href={{route('reviews.index')}} class="btn mdkbtn-primary p-2 mt-2 w-full text-center">Ver más</a>
                        </div>
                    </article>
                </section>
            </div>
            <div class="col-md-4">
                <section id="main-lateral" class="d-flex flex-col gap-x-2 flex-grow h-full">
                    <article class="card bg-slate-900  text-white basis-1/2">
                        <div class="card-header rounded-t-3xl font-medium text-lg" style="background: #1B204A">
                            Flujo Activo
                        </div>
                        <div class="card-body">
                            <p>Fecha de creación: {{$activeFlow->created_at}}</p>
                            <h3 class="font-medium text-lg">{{$activeFlow->name}}</h3>
                            <p>{{$activeFlow->objetivo}}</p>
                            <a href={{route('flows.index')}} class="btn mdkbtn-primary p-2 mt-2 w-full text-center">Ver más</a>
                        </div>
                    </article>
                    <article class="card basis-1/2">
                        <div class="card-body text-sky-950">
                            <h6 class="font-medium text-lg">Negocio Activo</h6>
                            <p class="my-4 font-medium text-2xl card-text">{{$activeBusiness->name}}</p>
                            <label class="rating-label d-flex flex-column justify-content-center align-items-center text-7xl">
                                {{number_format($activeBusiness->averageRating, 1)}}
                                <input
                                name="rating"
                                class="rating mt-2"
                                max="5"
                                oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                style="--value:{{$activeBusiness->averageRating}}; --starsize: 4rem; --fill: #D29D53"
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

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

