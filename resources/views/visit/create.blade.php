<x-visitor-layout>
    <div class="min-h-screen flex flex-col justify-center my-0">
        <div class="my-4 py-3">
            <h2 class="text-center">¡Te damos la bienvenida a {{$business["name"]}}! 👋</h2>
        </div>
    
        <div class="card mt-3 mb-5 mx-3 mx-md-0">
            <div class="card-body">
                <form class="p-3"  method="POST" action="{{route('visit.store', $businessId)}}">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="firstName" class="form-label">Nombre</label>
                            <input type="text" class="form-control"  name="firstName" id="firstName" required>
                        </div>
                        <div class="form-group col-md-6 mt-3 mt-md-0">
                            <label for="lastName" class="form-label">Apellido</label>
                            <input type="text" class="form-control"  name="lastName" id="firstName" required>
                        </div>
                    </div>
                        <div class="form-group col-md-12">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="tel" pattern="[0-9]{9}" class="form-control" name="phone" id="phone" required>
                        </div>
                    <div class="mt-3">
                        <button type="submit" class="mdkbtn-success px-4 py-2 focus:outline-none focus:ring focus:ring-indigo-500 w-full">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-visitor-layout>
