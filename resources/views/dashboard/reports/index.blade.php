@extends('adminlte::page')

@section('title', 'Reportes - Opiniones')

@section('content_header')
    <h1>Opiniones</h1>
@stop

@section('content')
    <section id="resumen" class="grid grid-cols-4 gap-5">
        <div class="card basis-1/4">
            <div class="card-body">
                <h6 class="font-medium">Negocio Activo</h6>
                <p class="my-4 font-medium card-text">{{$business->name}}</p>
                <label class="rating-label d-flex flex-column justify-content-center align-items-center text-4xl">
                    {{number_format($business->averageRating, 1)}}
                    <input
                    name="rating"
                    class="rating mt-2"
                    max="5"
                    oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                    style="--value:{{number_format($business->averageRating, 1)}}; --starsize: 2rem"
                    type="range"
                    disabled
                >
                </label>
            </div>
        </div>
        <div class="card basis-1/4">
            <div class="card-body">
                <h6 class="font-medium text-lg">Total Opiniones</h6>
                <div class="row my-2">
                    <div>                
                        <p class="card-text text-6xl">{{count($allReviews)}}</p>
                        <div class="p-1 rounded-md" style="background: #FFEFE7;">
                            <p class="text-xs">+{{$lastMonthReviewsVariation}}% Mes pasado</p>
                        </div>
                    </div>
                    <div class="ml-0 pl-1">
                        <p class="text-sm text-gray-500">{{count($goodReviews)}} Positivas</p>
                        <p class="text-sm text-gray-500">{{count($badReviews)}} Negativas</p>
                    </div>
                </div>
                <a href="#" class="btn mdkbtn-primary mt-2 p-2 w-full text-center">Ver más</a>
            </div>
        </div>
        <div class="card basis-1/4">
            <div class="card-body">
                <h6 class="font-medium text-lg">Total Clientes</h6>
                <div class="row my-2">
                    <div>                
                        <p class="card-text text-6xl">{{count($allReviews)}}</p> <!--Aquí cambiar-->
                        <div class="p-1 rounded-md" style="background: #FFEFE7;">
                            <p class="text-xs">+{{$lastMonthReviewsVariation}}% Mes pasado</p> <!--Aquí cambiar-->
                        </div>
                    </div>
                    <div class="ml-0 pl-1">
                        <p class="text-sm text-gray-500">{{count($goodReviews)}} Recurrentes</p> <!--Aquí cambiar-->
                    </div>
                </div>
                <a href="#" class="btn mdkbtn-primary mt-2 p-2 w-full text-center">Ver más</a>
            </div>
        </div>
        <div class="card basis-1/4">
            <div class="card-body">
                <h6 class="font-medium text-lg">Total Visitas</h6>
                <div class="col my-2">
                    <p class="card-text text-6xl">{{count($allVisits)}}</p>
                    <div class="p-1 rounded-md w-32" style="background: #FFEFE7;">
                        <p class="text-xs">+{{$lastMonthVisitsVariation}}% Mes pasado</p>
                    </div>
                </div>
                <a href="#" class="btn mdkbtn-primary p-2 mt-2 w-full text-center">Ver más</a>
            </div>
        </div>
    </section>

    <section id="search" class="d-flex justify-start">
        <form action="{{ route('reports.index') }}" method="GET">
            <input type="date" name="startDate" placeholder="Fecha de inicio">
            <input type="date" name="endDate" placeholder="Fecha de finalización">
            <button class="mdkbtn-success py-2 w-24 ml-md-2" type="submit">Filtrar</button>
        </form>
        <a href="{{ route('reports.index') }}" class="mdkbtn-danger py-2 w-24 text-center ml-md-2">Limpiar</a>
    </section>

    @if (request()->has('startDate') && request()->has('endDate'))
        <p><b>Fecha de inicio:</b> {{request()->startDate}}</p>
        <br>
        <p><b>Fecha de fin:</b> {{request()->endDate}}</p>
        <br>
        <p><b>Opiniones del Periodo:</b></p>
        <p>{{count($allReviewsByPeriod)}}</p>
        <hr>
        <p><b>Opiniones Positivas del Periodo:</b></p>
        <p>{{count($goodReviewsByPeriod)}}</p>
        <hr>
        <p><b>Opiniones Negativas del Periodo:</b></p>
        <p>{{count($badReviewsByPeriod)}}</p>
        <hr>
        <p><b>Visitas del Periodo:</b></p>
        <p>{{count($allVisitsByPeriod)}}</p>
    @endif
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

