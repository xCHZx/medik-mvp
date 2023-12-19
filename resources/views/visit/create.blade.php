<x-visitor-layout>
    <div class="min-h-screen flex flex-col justify-center my-0">
        <div class="card my-4 py-3 mx-3 flex flex-col items-center" style="background-color: #22836F">
            <h2 class="text-center text-white font-semibold text-xl">{{$business["name"]}}</h2>
            <x-logo-ico fill1="#fff" width="60" class="mt-4" height="30"/>
        </div>
        <div class="px-3 flex flex-col justify-center items-center text-center">
            <h1 class="font-bold text-xl">¡Gracias por confiar en nosotros!</h1>
            <div class="text-left w-[90%]">
                <p class="font-semibold text-base mt-4">Por favor, introduce la siguiente información para calificar nuestro servicio</p>
            </div>
        </div>
    
        <div class="card mt-2 mb-5 mx-3 mx-md-0">
            <div class="card-body px-2">
                <form class=""  method="POST" action="{{route('visit.store', $businessId)}}">
                @csrf
                    <div class="row mb-3 px-0">
                        <div class="form-group col-md-6">
                            <label for="firstName" class="form-label">Nombre(s)</label>
                            <input type="text" class="form-control"  name="firstName" id="firstName" required>
                        </div>
                        <div class="form-group col-md-6 mt-4 mt-md-0">
                            <label for="lastName" class="form-label">Apellido(s)</label>
                            <input type="text" class="form-control"  name="lastName" id="firstName" required>
                        </div>
                    </div>
                        <div class="form-group col-md-12 mt-4">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="tel" pattern="[0-9]{9,10}" class="form-control" name="phone" id="phone" required>
                        </div>
                    <div class="mt-3">
                        <button type="submit" class="mdkbtn-success px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-500 w-full">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-visitor-layout>
