<x-visitor-layout>
    <div class="mb-2">
        <h1 class="text-center">¡Gracias por tu Increíble Reseña!</h1>
    </div>
    <div class="mb-4">
        <h5 class="text-center">¡Nos llena de alegría saber que tu experiencia fue tan positiva! ❤️</h5>
    </div>
    <div class="card mx-3 py-3 px-3 d-flex flex-col justify-center align-middle font-medium">
        <div class="">
            <p class="text-center">
                Gracias por tomarte el tiempo para compartir tu opinión.
            </p>
        </div>
        <div class="d-flex flex-col align-middle justify-center">
            <img class="inline-block" alt="Gatito feliz 🐱" src="{{ url('/resources/images/goodReviewImg.webp') }}">
        </div>
        <div class="my-0 py-0">
            <p class="text-center mt-3 mb-0">
                Tu apoyo nos motiva a seguir mejorando para ofrecerte lo mejor
            </p>
        </div>
        @if ($links)
           @foreach ($links as $link)
              <a href="{{$link->url}}">{{$link->name}}</a>
           @endforeach
        @endif
    </div>
</x-visitor-layout>
