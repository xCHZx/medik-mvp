@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Hola</h1>
@stop

@section('content')
    <p>Bienvenido al panel de administración de <b>medik</b></p>


    <input id="card-holder-name" type="text">

<!-- Stripe Elements Placeholder -->
<div id="card-element"></div>

<button id="card-button" data-secret="{{ $intent->client_secret }}">
    Update Payment Method
</button>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

