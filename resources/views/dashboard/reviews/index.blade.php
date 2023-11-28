@extends('adminlte::page')

@section('title', 'Reportes - Opiniones')

@section('content_header')
    <h1>Opiniones</h1>
@stop

@section('content')
   @if(!$error)
     @foreach ($reviews as $review)
       <table>
           <tr>
               <th>Visitante</th>
               <th>Telefono</th>
               <th>flujo</th>
               <th>Calificacion</th>
               <th>Comentario</th>
               <th>Fecha</th>
          </tr>

          <tr>
              <td>{{$review->visit->visitor->firstName}}</td>
              <td>{{$review->visit->visitor->phone}}</td>
              <td>{{$review->flow->name}}</td>
              <td>{{$review->rating}}</td>
              <td>{{$review->comment}}</td>
              <td>{{$review->created_at}}</td>
     @endforeach

     {{$reviews->links()}}
    @else
       <p>no hay Opiniones para mostrar</p>
    @endif
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

