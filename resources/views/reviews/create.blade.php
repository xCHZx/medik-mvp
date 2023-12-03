<x-visitor-layout>
    <div class="my-4 py-3">
        <h2 class="text-center">¡Hola {{$visit->visitor->firstName}}, por favor brinda una opininión sobre! {{$visit->business->name}}👋</h2>
    </div>
    <div>
        <div class="card mx-3">
            <div class="card-body py-1.5 font-medium">
                <form class="px-2 py-0"  method="POST" action="{{route('review.update', $visitEncrypted)}}">
                @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label class="d-flex flex-column">
                                <p class="text-left my-1">Queremos saber cómo fue tu experiencia con nosotros.</p>
                                <p class="my-1">{{$visit->review->flow->alias}}. ¡Gracias por tu ayuda!</p>
                                <div class="d-flex justify-center mt-4 mb-2">
                                    <input
                                        name="rating"
                                        class="rating"
                                        max="5"
                                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)"
                                        style="--value:5"
                                        type="range"
                                        value="5"
                                        required
                                    >
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="comment" class="form-label">Tu opinión es importante para mejorar nuestro servicio.</label>
                        <textarea name="comment" id="comment" class="form-control mdkTextArea" rows="8"></textarea>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="mdkbtn-success w-full py-1">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-visitor-layout>
