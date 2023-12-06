@extends('adminlte::page')

@section('title', 'Mi Negocio')

@section('content_header')

    @if ($business)
        <h1 class="mt-2 mb-2">Mi <b>negocio</b>:</h1>
    @else
        <h1 class="mt-2">Actualmente <b>no</b> tienes ningún negocio registrado</h1>
        <h2 class="mt-2 mb-3">Para utilizar la plataforma, crea tu primer negocio👇</h2>
    @endif
@stop

@section('content')
    @if ($business)
        <div class="card">
            <div class="card-header border-0 pt-0">
                <div class="d-flex row justify-content-end">
                    <div class="mt-2">
                        <a href="{{route('business.edit',$business['id'])}}" target="_self" role="button" class="btn mdkbtn-info">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                            Editar información
                        </a>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div id="businessPicture" class="ml-2 mr-4 row justify-content-center" hidden>
                        <a class="btn d-flex flex-column justify-content-center align-items-center" href="#" value="#">
                            <div class="text-gray-500 d-flex flex-column justify-content-center align-items-center">
                                <i class="fas fa-upload"></i>
                                Subir logo
                            </div>
                        </a>
                    </div>
                    <div class="card-title p-1 h1 business-name">
                        <b class="d-inline">{{$business["name"]}} </b>
                        <p id="logo-medik" class="ml-2" hidden>-<x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="ml-1 d-inline -mt-3" width="100" height="50" /> </p>
                    </div>
                </div>
            </div>
            <div class="card-body mb-0">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <div class="mdkTextArea mdkBigTextArea">
                            <b class="text-gray-600">Descripción</b>
                            <p class="text-gray-500">{{$business["description"]}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mdkTextArea mdkBigTextArea ml-2">
                            <b class="text-gray-600">Dirección</b>
                            <p class="text-gray-500">{{$business["address"]}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer mb-2">
                <button type="button" class="btn mdkbtn-primary mr-2" data-toggle="modal" data-target="#qrModal">Ver código QR</button>
                <button type="button" class="btn mdkbtn-success" id="print">Imprimir QR</button>
            </div>
        </div>

        <div class="mx-auto qr" hidden>{!!$svg!!}</div>

        <!-- Modal -->
        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title h4" id="qrModalLabel">
                            QR de {{$business["name"]}}
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-auto">
                        <div>{!!$svg!!}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn mdkbtn-success" id="backPrint">Imprimir QR</button>
                            <button type="button" class="btn mdkbtn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="card">
            <div class="card-body">
                <form class="px-3 py-2" method="POST" action="{{route('business.store')}}">
                    @csrf
                    <div class="row mb-2">
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nombre del Negocio</label>
                            <input type="text" class="form-control"  name="name" id="name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" class="form-control"  name="address" id="address" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción o eslogan (opcional)</label>
                            <textarea class="form-control mdkTextArea" name="description" id="description" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="mt-2 mb-0">
                        <input name="businessId" value="" type="hidden" />
                        <button type="submit" class="mdkbtn-success py-1 px-3">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@stop

@section('js')
    <script>
        const printBtn = document.getElementById('print')
        printBtn.addEventListener('click', function(){
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
                '¡Listo!',
                'La acción se ha realizado con éxito',
                'success'
            )
        </script>
    @elseif (session("error") == "ok")
        <script>
            Swal.fire(
                'Oops...!',
                'Hubo un error con la operación, por favor verificar los campos o intenta más tarde',
                'warning'
            )
        </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

