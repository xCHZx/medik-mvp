@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    <div class="row d-flex justify-content-between align-items-center py-3">
        <div class="col-md-5">
            <h1> Estos son tus <b>flujos</b> 👇</h1>
        </div>

        <!-- Nuevo Flujo -->
        <div class="col-md-4">
            <div class="card text-center my-md-0 ">
                <a href="{{ route('flows.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo Flujo
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        @foreach($flows as $flow)
            <div class="col-md-12 mb-3">
                <div class="card card-flow">
                    <div>
                        <div class="card-header h5 py-2">{{$flow->name}}
                            <div class="card-subtitle h6 text-muted font-weight-normal mt-2">{{$businessName}}</div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-2">
                        <p class="card-text my-2">Objetivo: {{$flow->objetivo}}</p>
                        <p class="card-text my-2">Fecha de creacion : {{$flow->created_at}}</p>
                        
                        <div class="row d-flex justify-content-between align-items-center mt-4">

                            <!-- Editar -->
                            <form action="{{ route('flows.edit') }}" method="get">
                                @csrf
                                <input type="hidden" name="flowId" value="{{$flow->id}}">
                                <button type="submit" class="btn btn-outline-info">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <!-- Activar/Desactivar flujo -->
                            @if($flow->isActive)
                                
                                    <input type="hidden"  id="changestatusUrl" value="{{ route('flows.changeStatus') }}">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="{{$flow->id}}" value="false" checked>
                                        <label class="custom-control-label" for="{{$flow->id}}">Desactivar flujo</label>
                                    </div>
                                

                                @elseif($flow->isActive == false)

                                    <input type="hidden"  id="changestatusUrl" value="{{route('flows.changeStatus')}}">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="{{$flow->id}}" value="true">
                                        <label class="custom-control-label text-gray-500" for="{{$flow->id}}">Activar flujo</label>
                                    </div>
                               
                            @endif 

                            <!-- Activar/Desactivar flujo 
                        

                            ($flow->isActive == false)

                                <form method="POST" action="{{ route('flows.changeStatus') }}">
                                    @csrf
                                    <input type="hidden" name="flowId" value="{{$flow->id}}">
                                    <input type="hidden" name="activate" value="true">
                                    <button type="submit" class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label text-gray-500" for="customSwitch1">Activar flujo</label>
                                    </button>
                                </form>
                            -->

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/adminlte/dist/css/app.css">
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // tomamos el checbok y le agregamos un event listener
        let checkboxes = document.querySelectorAll('.custom-control-input');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function(event){
                let cheboxStatus = event.target;

                let flowId = cheboxStatus.id;
                let newStatus = cheboxStatus.value;

                const changestatusUrl = document.querySelector("#changestatusUrl").value;

                Swal.fire({
            title: 'Seguro que quieres hacer este cambio?',
            html:
            '<form id="formulario" method="POST" action="'+changestatusUrl+'">' +
                                    '@csrf' +
                                    '<input type="hidden" name="flowId" value= "'+flowId +'">' +
                                    '<input type="hidden" name="activate" value="'+newStatus+'">' +
      
            '</form>' ,
            
            showCancelButton: true,
            confirmButtonText: 'Si',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            }
            }).then((result) => {
                
            if (result.value == true) {
                let formulario = document.querySelector("#formulario");
                formulario.submit()
                Swal.fire('Listo!', '', 'success')
            } else{
                if(cheboxStatus.checked){
                    cheboxStatus.checked = false;
                }else{
                    cheboxStatus.checked = true;
                }
                Swal.fire('No se guardaron los cambios', '', 'info')
            }
            })


            })
        })
        

        
        
    </script>

    @if(session('flow-status') === 'error')
     @section('js')
        <script>
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'No puedes tener dos flujos activos al mismo tiempo, desactiva uno antes de activar otro',
                })
        </script>
   @endif

    @if(session('status') === 'Flow-Created')
     @section('js')
     <script>
              Swal.fire(
                   'Listo!',
                   'Flujo creado exitosamente!',
                   'success'
                )
     </script>
   @endif
@stop