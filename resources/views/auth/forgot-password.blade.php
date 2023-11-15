<x-visitor-layout>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center mb-1">
        <!-- Manito saludona -->
        <span class="text-4xl">&#128543;</span>

        <!-- Título -->
        <div class="flex justify-content-center align-content-center mt-2">
            <h1 class="text-2xl font-bold fs-4 text-gray-600 mt-3" style="padding-top: 0.13rem">
                ¿Olvidaste tu contraseña de
                <!-- Logo Medik -->
                <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="ml-1 mb-4 py-0 d-inline" width="100" height="50"/>
                ? 
            </h1>
            
        </div>

        <!-- Descripción -->
        <p class="text-gray-600 mt-2">¡No hay problema! <br>
            Déjanos tu correo electrónico y te ayudaremos a restablecerla.
        </p>
    </div>


    <form class="w-full sm:max-w-lg mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-600 ">Correo Electrónico</label>
            <input id="email" placeholder="email@example.com" class="form-control focus:border-indigo-500 focus:ring-indigo-500 shadow-sm block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col justify-content-between align-items-center mt-4 d-block d-sm-flex">
            <div class="col-12">
                <button class="px-4 py-2 mdkbtn-success rounded-md focus:outline-none focus:ring focus:ring-indigo-500 w-full">
                    Quiero recuperar mi contraseña!
                </button>
            </div>

            <div class="col-12 mt-2 text-center">
                <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:border-indigo-500 focus:ring-indigo-500" href="{{ route('login') }}">
                    Ya recordé mi contraseña! &#128073;&#128072; 
                </a>
            </div>
        </div>
    </form>
</x-visitor-layout>
