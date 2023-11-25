@extends('adminlte::page')

@section('title', 'Reportes - Opiniones')

@section('content_header')
    <h1>Reportes</h1>
@stop

@section('content')

    @if($business)
        <p><b>Negocio:</b></p>
        <p>{{$business->name}}</p>
        <hr>
        <p><b>Puntuación:</b></p>
        <p>{{number_format($business->averageRating, 1)}}</p>
        <hr>
        <form action="{{ route('reports.index') }}" method="GET">
            <input type="date" name="startDate" placeholder="Fecha de inicio">
            <input type="date" name="endDate" placeholder="Fecha de finalización">
            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
        </form>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-danger">Limpiar</a>
        <hr>


        <p><b>Total Opiniones:</b></p>
        <p>{{count($allReviews)}}</p>
        <hr>
        <p>+{{$lastMonthReviewsVariation}}% en los últimos 30 días</p>
        <hr>
        <p><b>Total Opiniones Positivas:</b></p>
        <p>{{count($goodReviews)}}</p>
        <hr>
        <p><b>Total Opiniones Negativas:</b></p>
        <p>{{count($badReviews)}}</p>
        <hr>
        <p><b>Total de Visitas:</b></p>
        <p>{{count($allVisits)}}</p>
        <hr>
        <p>+{{$lastMonthVisitsVariation}}% en los últimos 30 días</p>
        <hr>
        <br>
        <hr>
        <br>
        <hr>
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
    @else
        <h1>{{$msg}}</h1>
    @endif
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

