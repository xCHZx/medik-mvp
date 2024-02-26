<x-visitor-layout>
    <div class="text-center mb-1">
        <!-- Emojis seguridad fuerte -->
        <span class="text-4xl">🔐</span>

        <!-- Título -->
        <div class="flex justify-content-center align-content-center mt-2">
            <h1 class="text-2xl font-bold fs-4 text-gray-600 mt-3" style="padding-top: 0.13rem">
                Restablece tu contraseña de
                <!-- Logo Medik -->
                <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="ml-1 mb-4 py-0 d-inline" width="100" height="50"/>
            </h1>

        </div>

        <!-- Descripción -->
        <p class="text-gray-600 mt-2">Ingresa tus datos a continuación</p>
    </div>

    <form class="w-full sm:max-w-lg mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-600 ">Correo Electrónico</label>
            <input id="email" placeholder="email@example.com" class="form-control focus:border-indigo-500 focus:ring-indigo-500 shadow-sm block mt-1 w-full" type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" placeholder="••••••••" class="block text-sm font-medium text-gray-700" :value="__('Password')">Contraseña</label>
            <div>
                <input id="password" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un dígito" name="password" required autocomplete="new-password" />
                <span id="togglePassword" class="fas fa-eye-slash field-icon"></span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" placeholder="••••••••" class="block text-sm font-medium text-gray-700" :value="__('Confirm Password')">Repite la contraseña</label>
            <div>
                <input id="password_confirmation" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password_confirmation" required autocomplete="new-password" />
                <span id="togglePasswordConfirmation" class="fas fa-eye-slash field-icon"></span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <div class="col-12">
                <button class="px-4 py-2 mdkbtn-success rounded-md focus:outline-none focus:ring focus:ring-indigo-500 w-full">
                    Restablecer Contraseña
                </button>
            </div>
        </div>
    </form>
</x-visitor-layout>

<script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const togglePasswordConfirmation = document.getElementById("togglePasswordConfirmation");
    const passwordConfirmation = document.getElementById("password_confirmation");

    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        if (password.getAttribute('type') === "password") {
            password.setAttribute('type', "text");
        } else {
            password.setAttribute('type', "password");
        }

        // toggle the icon class
        if (password.getAttribute('type') === "text") {
            togglePassword.classList.remove("fa-eye-slash");
            togglePassword.classList.add("fa-eye");
        } else {
            togglePassword.classList.remove("fa-eye");
            togglePassword.classList.add("fa-eye-slash");
        }
    });

    togglePasswordConfirmation.addEventListener("click", function () {
        // toggle the type attribute
        if (passwordConfirmation.getAttribute('type') === "password") {
            passwordConfirmation.setAttribute('type', "text");
        } else {
            passwordConfirmation.setAttribute('type', "password");
        }

        // toggle the icon class
        if (passwordConfirmation.getAttribute('type') === "text") {
            togglePasswordConfirmation.classList.remove("fa-eye-slash");
            togglePasswordConfirmation.classList.add("fa-eye");
        } else {
            togglePasswordConfirmation.classList.remove("fa-eye");
            togglePasswordConfirmation.classList.add("fa-eye-slash");
        }    
    });
</script>
