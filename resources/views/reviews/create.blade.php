<x-visitor-layout>
<div class="mb-8">
    <h2>¡Hola {{$visit->visitor->firstName}}, por favor brinda una opininión sobre! {{$visit->business->name}}👋</h2>
</div>
<div>
    <div class="card">
        <div class="card-body">
            <form class="p-3"  method="POST" action="{{route('review.store', $visit->hashedId)}}">
            @csrf
                <div class="row mb-3">
                    <div class="form-group col-md-12">
                        <label for="rating" class="form-label">Aquí va el rating de estrellas</label>
                        <input type="number" class="form-control"  name="rating" id="rating" min="1" max="5" step="1" required>
                    </div>
                </div>
                    <div class="form-group col-md-12">
                        <label for="comment" class="form-label">Coment (Aquí un textbox)</label>
                        <input type="text" class="form-control"  name="comment" id="comment">
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
              </form>
        </div>
    </div>
</div>
</x-visitor-layout>
