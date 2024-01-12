<x-visitor-layout>
    <div class="mb-3 px-3">
        <h1 class="text-center font-bold text-4xl">¡Gracias por tu increíble reseña! <br>💚</h1>
    </div>
    <div class="mb-5">
        <p class="text-lg font-bold" style="color: #22836F">Califícanos en nuestras redes sociales</p>
        <div class="w-1/2 mx-auto flex justify-center">
            <div class="flex flex-row justify-around w-full">
                @if ($links)
                    @foreach ($links as $link)
                        <a href="{{$link->url}}" class="mdkbtn-success py-2 px-3">
                            @if ($link->name === 'facebook')
                                <i class="fab fa-facebook-square fa-lg p-0 m-0"></i>
                            @elseif ($link->name === 'google')
                                <i class="fab fa-google fa-lg p-0 m-0"></i>
                            @endif
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="mb-1 px-3">
        <h5 class="text-left font-semibold">¡Nos llena de alegría saber que tu experiencia fue tan positiva! 😊</h5>
    </div>
    <div class="card mx-3 py-3 px-3 d-flex flex-col justify-center items-center font-medium">
        <div class="d-flex flex-col align-middle justify-center mb-3">
            <img class="inline-block" alt="Gatito feliz 🐱" src="{{ url('/resources/images/goodReviewImg.svg') }}">
        </div>
        <div class="px-3 flex flex-col justify-center">
            <p class="text-left text-sm font-semibold">
                Gracias por tomarte el tiempo para compartir tu opinión con nosotros, ¡tu apoyo nos motiva a seguir mejorando para ofrecerte lo mejor!
            </p>
        </div>
        <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="mt-2" width="100" height="50"/>
    </div>
</x-visitor-layout>
