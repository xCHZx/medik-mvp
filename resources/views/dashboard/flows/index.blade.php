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
                <a href="{{ route('flows.create') }}" class="btn mdkbtn-success">
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
                <div class="card card-flow mdkFlowCard {{ $flow->isActive ? '' : 'mdkFlowInactive' }}">
                    <div>
                        <div class="card-header h5 py-2">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="flowCard" id="{{$flow->id}}">{{$flow->name}}</p>
                                    <div class="card-subtitle h6 text-muted font-weight-normal mt-2">{{$businessName}}</div>
                                </div>
                                <div>
                                    <!-- Editar -->
                                    <form action="{{ route('flows.edit') }}" method="get">
                                        @csrf
                                        <input type="hidden" name="flowId" value="{{$flow->id}}">
                                        <button type="submit" class="btn mdkbtn-info">
                                            <i class="fas fa-edit mr-1"></i>Editar flujo
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-2">
                        <p class="card-text my-2">Objetivo: {{$flow->objective}}</p>
                        <p class="card-text my-2">Fecha de creación: {{ date('d/m/Y \a \l\a\s H:i', strtotime($flow->created_at)) }}</p>
                        <div class="row d-flex justify-content-between align-items-center mt-4">

                            <!-- Delete >
                            <button type="button" class="btn mdkbtn-danger" data-toggle="modal" data-target="#deleteModal" data-name="{{$flow->name}}" data-id="{{ $flow->id}}">
                                <i class="fas fa-trash-alt mr-1"></i>Eliminar
                            </button-->
                            

                            <!-- Activar/Desactivar flujo -->
                            <button type="button" class="custom-control custom-switch" data-toggle="modal" data-target="#staticBackdrop" data-name="{{$flow->name}}" data-status="{{ $flow->isActive}}" data-id="{{ $flow->id}}">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" {{ $flow->isActive ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customSwitch1">
                                    {{ $flow->isActive ? 'Desactivar flujo' : 'Activar flujo' }}
                                </label>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal delete -->
    <div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="d-flex justify-content-end">
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="deleteFlow" method="POST" action="{{ route('flows.delete') }}">
                    @csrf
                    <div class="form-group">
                        ¿Estas seguro de <b>eliminar</b> el flujo: <b id="flowName"></b>?
                    </div>
                    <div class="form-group">
                        <input class="inputDelete" type="hidden" name="flowId" value="{{$flow->id}}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mdkbtn-danger" data-dismiss="modal">Cancelar</button>
                <button id="submitDelete" class="btn mdkbtn-success">Confirmar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal changeStatus -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="d-flex justify-content-end">
                <button type="button" class="close mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="changeStatus" method="POST" action="{{ route('flows.changeStatus') }}">
                    @csrf
                    <div class="form-group">
                        ¿Estas seguro de <b id="word"></b> el flujo: <b id="flowName"></b>?
                    </div>
                    <div class="form-group">
                        <input class="input1" type="hidden" name="flowId">
                        <input class="input2" type="hidden" name="activate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mdkbtn-danger" data-dismiss="modal">Cancelar</button>
                <button id="submitFormButton" type="submit" class="btn mdkbtn-success">Confirmar</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            @switch(session('status'))
                @case('Flow-Created')
                    Swal.fire(
                        'Listo!',
                        'El flujo fue creado con éxito',
                        'success'
                    );
                    @break;
                @case('Flow-Changed')
                    Swal.fire(
                        'Listo!',
                        'El flujo fue actualizado',
                        'success'
                    );
                @break;                    
            @endswitch

            @switch(session('flow-status'))
                @case('success')
                    Swal.fire(
                        'Listo!',
                        'Flujo eliminado',
                        'success'
                    );
                    @break;
                @case('error')
                    Swal.fire(
                        'Oops...',
                        'No puedes tener activos dos flujos a la vez, desactiva uno antes de activar otro',
                        'error'
                    );
                @break;                    
            @endswitch

            /*Cambiar estado del flujo */
            $('#staticBackdrop').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botón que activó el modal changeStatus
                var flowStatus = button.data('status');
                var flowNamed = button.data('name');
                var flowID = button.data('id');
                var modal = $(this);

                modal.find('#flowName').text(flowNamed);
                if (flowStatus === 1) {
                    modal.find('#word').text('desactivar');
                    modal.find('.input2').val('false');
                } else {
                    modal.find('#word').text('activar');
                    modal.find('.input2').val('true');
                }

                modal.find('.input1').val(flowID);
            });

            document.getElementById('submitFormButton').addEventListener('click', function () {
                document.getElementById('changeStatus').submit();
            });

            /*Eliminar flujo*/
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Botón que activó el modalDelete
                var flowNamed = button.data('name');
                var flowID = button.data('id');
                var modal = $(this);

                modal.find('#flowName').text(flowNamed);
                modal.find('.inputDelete').val(flowID);
            });

            document.getElementById('submitDelete').addEventListener('click', function () {
                document.getElementById('deleteFlow').submit();
            });
        });
    </script>
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop
