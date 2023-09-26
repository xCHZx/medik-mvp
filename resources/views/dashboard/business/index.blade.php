@extends('adminlte::page')

@section('title', 'Mi Negocio')

@section('content_header')

    @if ($business)
        <h1 class="mt-5 mb-5">Tus <b>negocios</b> registrados:</h1>
    @else
        <h1 class="mt-5">Actualmente <b>no</b> tienes ningún negocio registrado</h1>
        <h2 class="mt-2 mb-5">Para utilizar la plataforma, crea tu primer negocio👇</h2>
    @endif


@stop

@section('content')


    @if ($business)

    <div class="card">
        <div class="card-header">
            <h1 class="card-title p-1"><b>{{$business["name"]}}</b></h1>
            <div class="d-flex">
                <div class="ml-auto p-1">
                    <a href="{{route('business.edit',$business['id'])}}" target="_self" role="button" class="btn btn-outline-info btn-sm">
                        <span class="fas fa-edit" aria-hidden="true"></span>
                        Editar información
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <b>Descripción</b>
                    <p>{{$business["description"]}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <b>Dirección</b>
                    <p>{{$business["address"]}}</p>
                </div>
            </div>
        </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#qrModal">Ver código QR</button>
            <button type="button" class="btn btn-outline-success" id="print">Imprimir QR</button>
        </div>
    </div>

    <div class="mx-auto qr">{!!$svg!!}</div>

<!-- Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="qrModalLabel">QR de {{$business["name"]}}</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-auto">
            <div>{!!$svg!!}</div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-success" id="backPrint">Imprimir QR</button>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

    @else

        <div class="card">
            <div class="card-body">
                <form class="p-3" method="POST" action="{{route('business.store')}}"">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nombre del Negocio</label>
                            <input type="text" class="form-control"  name="name" id="name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control"  name="address" id="address" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción (opcional)</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input name="businessId" value="" type="hidden" />
                        <button type="submit" class="btn btn-outline-success">Guardar</button>
                    </div>
                  </form>
            </div>
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

