<x-visitor-layout>
    
    <div class="text-center mb-0">
        <!-- Manito felicidades -->
        <span class="text-4xl">🙌</span>

        <!-- Título -->
        <div class="flex justify-content-center align-content-center mt-0 mb-0">
            <h1 class="text-2xl font-bold fs-4 text-gray-600 mt-3" style="padding-top: 0.13rem">
                ¡Gracias por registrarte a 
                <!-- Logo Medik -->
                <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="ml-1 mb-4 py-0 d-inline" width="100" height="50"/>
                !
            </h1>
        </div>
    </div>

    <div class="card mt-0 p-3">
        <!-- Descripción -->
        <div class="text-gray-600 mb-2 text-center">
            <h5 class="mb-3">✋ Antes de comenzar</h5>
            <p class="text-left">¿Podrías verificar tu correo electrónico haciendo clic en el enlace que te hemos enviado?<br>
                Si no recibiste el correo, con gusto te enviaremos otro.</p>
        </div>

        <!-- Session Status -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                Te hemos enviado un nuevo enlace de verificación al correo electrónico que proporcionaste en tu registro.
            </div>
        @endif
        
        <div class="d-flex align-items-center justify-around">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <button class="w-96 px-4 py-2 mdkbtn-warning rounded-md focus:outline-none focus:ring focus:ring-indigo-500">
                        Reenviar correo de verificación
                    </button>
                </div>
            </form>
    
            <form method="POST" class="" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ml-3 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-power-off text-red-500"></i>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>

    
</x-visitor-layout>
