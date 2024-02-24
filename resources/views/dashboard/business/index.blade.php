@extends('adminlte::page')

@section('title', 'Mi Negocio')

@section('content_header')

    @if ($business)
        <h1 class="mt-2 mb-2 text-sky-950 text-2xl">Información de tu negocio</h1>
    @else
        <h1 class="mt-2 text-sky-950 text-2xl">Actualmente <b>no</b> tienes ningún negocio registrado</h1>
        <h2 class="mt-2 mb-3">Para utilizar la plataforma, crea tu primer negocio👇</h2>
    @endif
@stop

@section('content')
    @if ($business)
        <div class="">
            <div class="card-header border-2 border-green-400 rounded-t-xl bg-emerald-50">
                <!--div class="row align-items-center" -->
                    <!-- div id="businessPicture" class="ml-2 mr-4 row justify-content-center" hidden>
                        <a class="btn d-flex flex-column justify-content-center align-items-center" href="#" value="#">
                            <div class="text-gray-500 d-flex flex-column justify-content-center align-items-center">
                                <i class="fas fa-upload"></i>
                                Subir logo
                            </div>
                        </a>
                    </div -->
                    <div class="card-title p-1 h1 business-name">
                        <b class="d-inline text-sky-950 font-semibold">{{$business["name"]}} </b>
                    </div>
                <!--/div-->                
                <div class="d-flex row justify-content-end">
                    <div class="mt-1">
                        <a href="{{route('business.edit',$business['id'])}}" target="_self" role="button" class="btn mdkbtn-info">
                            <span class="fas fa-edit" aria-hidden="true"></span>
                            Editar información
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body mb-0 border-x-2 border-green-400 bg-white">
                <div class="col justify-content-between">
                    <div class="row mb-4">
                            <b class="text-gray-600">Descripción:&nbsp;</b>
                            @if ($business["description"])
                                <p class="text-gray-500">{{$business["description"]}}</p>
                            @else
                                <p class="text-gray-500">No tienes una descripción de tu negocio</p>
                            @endif
                    </div>
                    <div class="row mb-4">
                            <b class="text-gray-600">Dirección:&nbsp;</b>
                            <p class="text-gray-500">{{$business["address"]}}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer mb-2 border-x-2 border-b-2 border-green-400 rounded-b-xl bg-white">
                <button type="button" class="btn mdkbtn-primary mr-3 w-44" data-toggle="modal" data-target="#qrModal">Ver código QR</button>
                <button type="button" class="btn mdkbtn-success w-44" id="downloadQR">Descargar QR</button>
            </div>
        </div>

        <div class="mx-auto qr" hidden>{!!$svg!!}</div>

        <!-- Modal -->
        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bg-emerald-50">
                    <div class="modal-header bg-white">
                        <div class="modal-title h4" id="qrModalLabel">
                            Así se verá tu código QR cuando lo imprimas
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-auto">
                        <article class="card col-12">
                            <div class="card-body row justify-around">
                                <div class="col-5 justify-between">
                                    <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="my-3" width="100" height="50"/>
                                    <div class="btn mdkbtn-success w-44 text-white font-semibold my-4">{{$business["name"]}}</div>
                                    <article>
                                        <h5 class="font-semibold text-base my-3">Con este código QR podrás</h5>
                                        <ul class="text-gray-500 list-disc list-inside text-sm">
                                            <li class="mb-1">Calificar nuestro servicio</li>
                                            <li class="mb-1">Dejar tus comentarios</li>
                                            <li class="mb-1">Nos podrás seguir en todas nuestras redes sociales</li>
                                        </ul>
                                    </article>
                                </div>
                                <div class="col-6">
                                    <div>{!!$svg!!}</div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="modal-footer bg-white">
                        <button type="button" class="btn mdkbtn-success w-44" id="backDownload">Descargar QR</button>
                        <button type="button" class="btn mdkbtn-danger w-44" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="">
            <div class="card-body bg-white border-2 rounded-xl border-green-400">
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
        const printBtn = document.getElementById('downloadQR')
        printBtn.addEventListener('click', function(){
            alert("Agregar logica de descargar imagen");
            //print();
        })

        const printBtnModal = document.getElementById('backDownload')
        printBtnModal.addEventListener('click', function(){
            $('#qrModal').modal('hide')
            setTimeout(() => {
                alert("Agregar logica de descargar imagen");
                //print();
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

