@extends('adminlte::page')

@section('title', 'Reportes - Opiniones')

@section('content_header')
    <h1 class="text-slate-950 mb-2">Reportes</h1>
@stop

@section('content')
    <section id="resumen" class="grid grid-cols-3 gap-5">
        <div class="card basis-1/4">
            <div class="card-body text-sky-950 pb-1.5">
                <h6 class="font-medium text-lg">Negocio Activo</h6>
                <p class="my-3 font-medium card-text text-xl">{{$business->name}}</p>
                <label class="d-flex flex-column justify-content-center align-items-center">
                    <p class="font-normal text-6xl">{{number_format($business->averageRating, 1)}}</p>
                    <input
                    name="rating"
                    class="rating mt-2"
                    max="5"
                    style="--value:{{number_format($business->averageRating, 1)}}; --starsize: 3.3rem"
                    type="range"
                    disabled
                >
                </label>
            </div>
        </div>
        <div class="card basis-1/4">
            <div class="card-body text-sky-950 flex flex-col justify-between">
                <h6 class="font-medium text-lg">Total Opiniones</h6>
                <div class="col my-2">
                    <div class="row">
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
                </div>
                <a href="opiniones" class="btn mdkbtn-primary mt-2 p-2 w-full text-center">Ver más</a>
            </div>
        </div>
        {{-- <div class="card basis-1/4">
            <div class="card-body text-sky-950">
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
        </div> --}}
        <div class="card basis-1/4">
            <div class="card-body text-sky-950 flex flex-col justify-between">
                <h6 class="font-medium text-lg">Total Visitas</h6>
                <div class="col my-2">
                    <p class="card-text text-6xl">{{count($allVisits)}}</p>
                    <div class="p-1 rounded-md w-32" style="background: #FFEFE7;">
                        <p class="text-xs">+{{$lastMonthVisitsVariation}}% Mes pasado</p>
                    </div>
                </div>
                <a href="opiniones" class="btn mdkbtn-primary p-2 mt-2 w-full text-center">Ver más</a>
            </div>
        </div>
    </section>

    <section id="search" class="d-flex justify-start my-4">
        <form action="{{ route('reports.index') }}" method="GET" onsubmit="updateDateInputs()">
            <label>
                Desde
                <input
                    onfocus="toggleIcon(this)"
                    onblur="toggleIcon(this)"
                    type="text"
                    name="startDate"
                    class="form-control mt-1 w-48"
                    value="{{ request()->has('startDate') ? request()->input('startDate') : '' }}"
                    placeholder="Fecha de inicio"
                >
                <i class="far fa-calendar-alt text-gray-400 calendar-icon" onclick="handleIconClick(this)"></i>
            </label>
            <label class="ml-md-2">
                Hasta
                <input
                    onfocus="toggleIcon(this)"
                    onblur="toggleIcon(this)"
                    type="text"
                    name="endDate"
                    class="form-control mt-1 w-48"
                    value="{{ request()->has('endDate') ? request()->input('endDate') : '' }}"
                    placeholder= "Fecha de fin"
                >
                <i class="far fa-calendar-alt text-gray-400 calendar-icon" onclick="handleIconClick(this)"></i>
            </label>
            <button class="mdkbtn-success py-2 w-24 ml-md-2" type="submit">Filtrar</button>
            <a href="{{ route('reports.index') }}" class="mdkbtn-danger py-2 d-inline-block text-center w-24 ml-md-2">Limpiar</a>
        </form>
    </section>

    <section id="search-result">
        @if (request()->has('startDate') && request()->has('endDate'))
            <section class="flex flex-row gap-5">
                <div class="card basis-1/2" style="background: #E8F0FB">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Total Opiniones</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{count($allReviewsByPeriod)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card basis-1/4" style="background: #E7FFF6">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Visitas</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{count($allVisitsByPeriod)}}</p> <!--Aquí cambiar-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card basis-1/4" style="background: #FFE7FA">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Flujos enviados</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{$reviewsSend}}</p> <!--Aquí cambiar-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="flex flex-row gap-5">
                <div class="card basis-1/4" style="background: #D9D9D9">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Opiniones Positivas</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{count($goodReviewsByPeriod)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card basis-1/4" style="background: #EDD2D2">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Opiniones Negativas</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{count($badReviewsByPeriod)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card basis-1/4" style="background: #A5F1FB">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Tasa de Participación</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{$responseRate}}%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card basis-1/4" style="background: #C2DBFF">
                    <div class="card-body text-sky-950">
                        <h6 class="font-medium text-lg">Flujos inconclusos</h6>
                        <div class="row my-2">
                            <div>
                                <p class="card-text text-6xl">{{$reviewsNotCompleted}}</p> <!--Aquí cambiar-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </section>
@stop

@section('js')
    <script>
        function toggleIcon(input) {
            const icon = input.nextElementSibling;
            if (input.type === 'text') {
                input.type = 'date';
                icon.style.display = 'none';
            } else {
                input.type = 'text';
                icon.style.display = 'inline-block';
            }
        }
    </script>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

