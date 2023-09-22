<x-visitor-layout>
<div class="mb-8">
    <h2>¡Te damos la bienvenida a {{$business["name"]}}! 👋</h2>
</div>
<div>
    <div class="card">
        <div class="card-body">
            <form class="p-3"  method="POST" action="{{route('visitor.store', $id)}}">
            @csrf
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="firstName" class="form-label">Nombre</label>
                        <input type="text" class="form-control"  name="firstName" id="firstName" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastName" class="form-label">Apellido</label>
                        <input type="text" class="form-control"  name="lastName" id="firstName" required>
                    </div>
                </div>
                    <div class="form-group col-md-12">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="number" class="form-control"  name="phone" id="phone" required>
                    </div>
                <div class="mt-3">
                    <input name="businessId" value="{{ $id }}" type="hidden" />
                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>
              </form>
        </div>
    </div>
</div>
</x-visitor-layout>
