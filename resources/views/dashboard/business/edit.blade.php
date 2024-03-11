@extends('adminlte::page')

@section('title', 'Mi Negocio')

@section('content_header')

    @if ($business)
        <h1 class="mt-2 mb-2 text-sky-950">Edición de negocio</h1>
    @else
        <h1 class="mt-3">Actualmente <b>no</b> tienes ningún negocio registrado</h1>
        <h2 class="mt-2 mb-3">Para utilizar la plataforma, crea tu primer negocio👇</h2>
    @endif


@stop

@section('content')
        <div class="">
            <div class="card-body bg-white rounded-xl border-2 border-green-400">
                <form class="p-3" method="POST" action="{{route('business.update', $business["id"])}}">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label for="name" class="form-label">Nombre del Negocio</label>
                            <input type="text" class="form-control mdkTextArea" value="{{$business["name"]}}"  name="name" id="name" required>
                            <p id="charRemaining" class="text-cyan-500"></p>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label">Descripción o slogan (opcional)</label>
                            <input type="text" class="form-control mdkTextArea" name="description" id="description" value="{{$business["description"]}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address" class="form-label">Dirección</label>
                            <textarea class="form-control mdkTextArea" name="address" id="address" required>{{$business["address"]}}</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input name="businessId" value="" type="hidden" />
                        <button type="submit" class="btn mdkbtn-success">Guardar y regresar</button>
                        <a href="{{route('business.index')}}" role="button" class="btn mdkbtn-danger">Cancelar</a>
                    </div>
                  </form>
            </div>
        </div>


@stop

@section('js')
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

    <script>
        var businessName = document.getElementById("name");
        var currentLenght = businessName.value.length;
        var remaining = document.getElementById("charRemaining");
        var limit = 30;
        remaining.textContent = currentLenght + "/" + limit;

        businessName.addEventListener("input",function(){
            var textLength = businessName.value.length;
            remaining.textContent = textLength + "/" + limit;

            if(textLength > limit){
                remaining.style.color = "#C77500";
                remaining.textContent += " El nombre de tu negocio excede los 30 caracteres recomendados para una visualización óptima  ";
            }
            else{
                businessName.style.borderColor = "#b2b2b2";
                remaining.style.color = "#1a75ff";
            }
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

