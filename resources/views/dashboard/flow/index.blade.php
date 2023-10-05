@extends('adminlte::page')

@section('title', 'Flujos')

@section('content_header')
    @if ($flows->isEmpty())
        <h1 class="mt-5">No tienes ningún flujo registrado</h1>
        <h2 class="mt-2 mb-5">Crea tu primer flujo aquí 👇</h2>
    @else
        <h1 class="mt-5">Tus flujos registrados:</h1>
    @endif
@stop

@section('content')
    @if ($flows->isEmpty())
        <!-- Mostrar mensaje si no hay flujos -->
        <div class="card">
            <div class="card-body">
                <form class="p-3" method="POST" action="{{ route('flow.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nombre del Flujo</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción (opcional)</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-outline-success">Guardar Flujo</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Mostrar cards de flujos si hay flujos -->
        <div class="row mt-4">
            @foreach ($flows as $flow)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $flow->name }}</h5>
                            <p class="card-text">{{ $flow->description }}</p>
                            <a href="{{ route('flow.toggle', $flow->id) }}" class="btn {{ $flow->isActivated ? 'btn-danger' : 'btn-success' }} btn-sm">
                                {{ $flow->isActivated ? 'Apagar' : 'Encender' }}
                            </a>
                            <a href="{{ route('flow.edit', $flow->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@stop


@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
    <script>
        const printBtn = document.getElementById('print')
        printBtn.addEventListener('click', function(){
            // $('#qrModal').modal('hide')
            print();
        })

        const printBtnModal = document.getElementById('backPrint')
        printBtnModal.addEventListener('click', function(){
            $('#qrModal').modal('hide')
            setTimeout(() => {
                print();
            }, 500);
        })
    </script>

    @if (session("action") == "ok")
        <script>
            Swal.fire(
                '¡Realizado!',
                'La acción se ha realizado con éxito',
                'success'
            )
        </script>
    @elseif (session("error") == "ok")
        <script>
            Swal.fire(
                '¡Error!',
                'Hubo un error con la operación, por favor verificar los campos o intenta más tarde',
                'warning'
            )
        </script>
    @endif

@stop

