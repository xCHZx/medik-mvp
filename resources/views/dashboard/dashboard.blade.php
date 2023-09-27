@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Hola {{$user["firstName"]." ".$user["lastName"]}}</h1>
@stop

@section('content')
    <p>Bienvenido al panel de administración de <b>medik</b></p>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

