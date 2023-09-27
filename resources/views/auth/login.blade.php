<x-visitor-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center mb-1">
        <!-- Manito saludona -->
        <span class="text-4xl">&#x1F44B;</span>

        <!-- Título -->
        <div class="flex justify-content-center align-content-center">
            <h1 class="text-2xl font-bold fs-4 text-gray-600 dark:text-gray-400 mt-2">
                Bienvenido a 
            </h1>
            <!-- Logo Medik -->
            <img src="{{ asset('images/LogoMedik.svg') }}" alt="LogoMediK" width="auto" class="h-9 inline-block ml-2 mt-n5">
        </div>

        <!-- Descripción -->
        <p class="text-gray-600 dark:text-gray-400 mt-2">Inicia sesión con tu cuenta para acceder a la plataforma</p>
    </div>

    <form class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-600 dark:text-gray-400">Correo Electrónico</label>
            <input id="email" placeholder="email@example.com" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
            <div class="mt-2 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-600 dark:text-gray-400">Contraseña</label>
            <input id="password" placeholder="••••••••" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" type="password" name="password" required autocomplete="current-password">
            @error('password')
            <div class="mt-2 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me and Password Recovery-->
        <div class="flex justify-content-between align-content-center mb-3">
            <!-- Recuerdame... hoy me tengo que ir mi amor, recuerdame -->
            <div class="flex justify-content-center align-content-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-teal-600 shadow-sm focus:ring focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                </label>
            </div>

            <!-- Password Request-->
            <div>
                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
            </div>
        </div>        

            <div>
                <button class="px-4 py-2 text-white bg-teal-600 rounded-md hover:bg-teal-800 focus:outline-none focus:ring focus:ring-indigo-500 w-full">
                    Iniciar sesión
                </button>
            </div>
        
    </form>
</x-visitor-layout>
