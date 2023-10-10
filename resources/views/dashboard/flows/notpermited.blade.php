@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <h1> {{$message}} </h1>
@stop

@section('content')
    <p>Da click al boton para <b>Crear un negocio</b></p>
    <a href="panel/negocio">
    <button type="button" class="btn btn-outline-info">Crear Negocio</button>
    </a>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop