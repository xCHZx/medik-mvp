@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <h1 class="mt-4"> {{$message}} &#129299;&#9757; </h1>
@stop

@section('content')
    <h2 class="mt-0">Da click al botón para <b>crear un negocio</b></h2>
    <a href="{{ route('business.index') }}" >
        <button type="button" class="btn btn-outline-info my-3">Crear Negocio</button>
    </a>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop