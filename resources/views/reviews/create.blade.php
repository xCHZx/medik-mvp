<x-visitor-layout>
    <div class="my-4 py-3">
        <h2 class="text-center">¡Hola {{$visit->visitor->firstName}}, por favor brinda una opininión sobre! {{$visit->business->name}}👋</h2>
    </div>
    <div>
        <div class="card mx-3">
            <div class="card-body">
                <form class="px-2 py-3"  method="POST" action="{{route('review.update', $visitEncrypted)}}">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label class="rating-label d-flex flex-column justify-content-center align-items-center">
                                <p>¿Cómo calificarías la {{$visit->review->flow->objetivo }}en {{$visit->business->name}}?</p>

                                <input
                                    name="rating"
                                    class="rating"
                                    max="5"
                                    oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                    style="--value:5"
                                    type="range"
                                    value="5"
                                    required>
                            </label>
                        </div>
                    </div>
                        <div class="form-group col-md-12">
                            <label for="comment" class="form-label">Déjanos tu opinión</label>
                            <textarea name="comment" id="comment" class="form-control mdkTextArea" rows="8">
                            </textarea>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="mdkbtn-success w-full py-1">Enviar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-visitor-layout>
