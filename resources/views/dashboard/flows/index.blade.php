@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <h1> Tus flujos </h1>
@stop

@section('content')

@if (session('flow-status') === 'error')
     <h5>no puedes tener dos flujos activos al mismo tiempo, desactiva uno antes de activar otro</h5>
@endif


<a href="{{ route('flows.create') }}" >
        <button type="button" class="btn btn-outline-info my-3">Agregar flujo</button>
    </a>
@foreach($flows as $flow)
        <div class="card" style="width: 50rem;">
          <div class="card-body">
            <h5 class="card-title mb-2">{{$flow->name}}  </h5>
            <h6 class="card-text">objetivo : {{$flow->objetivo}}   </h6>
            <p class="card-text mb-2">fecha de creacion : {{$flow->created_at}}</p>
            <form method="get" action="{{ route('flows.edit') }}">
                    @csrf
                    <input type="hidden" name="flowId" value="{{$flow->id}}">
                    <button type="send" class="btn btn-outline-info">Editar</button>
                </form>
            @if($flow->isActive)
                <form method="POST" action="{{ route('flows.changeStatus') }}">
                    @csrf
                    <input type="hidden" name="flowId" value="{{$flow->id}}">
                    <input type="hidden" name="activate" value="false">
                    <button type="send" class="btn btn-outline-info">Desactivar flujo</button>
                </form>
            @endif

            @if($flow->isActive == false)
                <form method="POST" action="{{ route('flows.changeStatus') }}">
                    @csrf
                    <input type="hidden" name="flowId" value="{{$flow->id}}">
                    <input type="hidden" name="activate" value="true">
                    <button type="send" class="btn btn-outline-info">Activar flujo</button>
                </form>
            @endif

          </div>
        </div>
@endforeach

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