@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <h1> Tus flujos </h1>
@stop

@section('content')



<div class="card" style="width: 50rem;">
  <div class="card-body">
    <h5 class="card-title mb-2">{{$flow->name}}  </h5>
    <h6 class="card-text">El tiempo de espera para empezar es de: {{$flow->waitingHours}}   </h6>
    <p class="card-text mb-2">El tiempo para que se dispare el recordatorio es de : {{$flow->forwardingTime}}    </p>
    <a href="#" class="card-link">Editar Flujo</a>
    @if($flow->isActive)
        
        <button type="button" class="btn btn-outline-info">Desactivar flujo</button>
    @endif

  </div>
</div>

@if(session('status') === 'Flow-Created')
     @section('js')
     <script>
              Swal.fire(
                   'LIsto!',
                   'Flujo creado exitosamente!',
                   'success'
                )
     </script>
   @endif
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop