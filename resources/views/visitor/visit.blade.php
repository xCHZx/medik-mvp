<x-visitor-layout>
<div class="mb-8 mx-3 text-center">
    <h2>¡Te damos la bienvenida a {{$business["name"]}}! 👋</h2>
</div>
<div class="mx-3">
    <div class="card">
        <div class="card-body">
            <form class="p-3"  method="POST" action="{{route('visitor.store', $id)}}">
            @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="firstName" class="form-label">Nombre</label>
                        <input type="text" class="form-control"  name="firstName" id="firstName" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastName" class="form-label mt-3">Apellido</label>
                        <input type="text" class="form-control"  name="lastName" id="firstName" required>
                    </div>
                </div>
                    <div class="form-group col-md-12">
                        <label for="phone" class="form-label mt-3">Teléfono</label>
                        <input type="number" class="form-control"  name="phone" id="phone" required>
                    </div>
                <div class="mt-4 text-center col-12">
                    <input name="businessId" value="{{ $id }}" type="hidden" />
                    <button type="submit" class="btn btn-success col-12">Enviar</button>
                </div>
              </form>
        </div>
    </div>
</div>
</x-visitor-layout>
