<x-visitor-layout>

    <!-- Greeting section -->
    <div class="text-center mb-1">
        <!-- Carita chula -->
        <span class="text-4xl">&#128526;</span>

        <!-- Título -->
        <div class="flex justify-content-center align-content-center mt-2" style="margin-botton: -0.25rem">
            <h1 class="text-2xl font-bold fs-4 text-gray-600 mt-3" style="padding-top: 0.13rem">
                Quiero unirme a
            </h1>
            <!-- Logo Medik -->
            <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="ml-1" viewBox="0 20 756 235" width="100" height="52"/>
            <h1 class="text-2xl font-bold fs-4 text-gray-600 mt-3" style="padding-top: 0.13rem">
                !
            </h1>
        </div>

        <!-- Descripción -->
        <p class="text-gray-600" style="margin-top: -0.25rem">Ingresa tus datos para registrarte con nosotros</p>
    </div>

    <div class="mx-3 mx-md-0">
        <!-- Form section -->
        <form class="w-full sm:max-w-lg mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row">

                <!-- First Name -->
                <div class="col-12 col-md-6">
                    <label for="firstName" class="block text-sm font-medium text-gray-700">Nombre(s)</label>
                    <input id="firstName" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="firstName" value="{{ old('firstName') }}" required autofocus autocomplete="firstName" />
                    @if ($errors->has('firstName'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('firstName') }}</p>
                    @endif
                </div>

                <!-- Last Name -->
                <div class="col-12 col-md-6 mt-4 mt-md-0">
                    <label for="lastName" class="block text-sm font-medium text-gray-700">Apellido(s)</label>
                    <input id="lastName" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="lastName" value="{{ old('lastName') }}" autocomplete="lastName" />
                    @if ($errors->has('lastName'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('lastName') }}</p>
                    @endif
                </div>

                <!-- Email -->
                <div class="col-12 col-md-6 mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input id="email" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    @if ($errors->has('email'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- Phone Number -->
                <div class="col-12 col-md-6 mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Número de Celular</label>
                    <input id="phone" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="tel" pattern="[0-9]{9,10}" name="phone" value="{{ old('phone') }}" autocomplete="phone" />
                    @if ($errors->has('phone'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('phone') }}</p>
                    @endif
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div>
                        <input id="password" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un dígito" name="password" required autocomplete="new-password" />
                        <span id="togglePassword" class="fas fa-eye-slash field-icon"></span>
                    </div>
                    @if ($errors->has('password'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Repite la contraseña</label>
                    <div>
                        <input id="password_confirmation" class="form-control block mt-1 w-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password_confirmation" required autocomplete="new-password" />
                        <span id="togglePasswordConfirmation" class="fas fa-eye-slash field-icon"></span>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

            </div>

            <div class="flex flex-col justify-content-between align-items-center mt-4 d-block d-sm-none">
                <!-- Mobile -->
                <div class="col-12 mt-4">
                    <button type="submit" class="mdkbtn-success w-full px-4 py-2 text-sm font-medium focus:outline-none focus:ring focus:border-indigo-500 focus:ring-indigo-500">
                        Registrarme
                    </button>
                </div>

                <div class="col-12 mt-2 text-center">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:border-indigo-500 focus:ring-indigo-500" href="{{ route('login') }}">
                        ¿Ya tienes una cuenta?
                    </a>
                </div>
            </div>

            <div class="justify-content-between align-items-center mt-4 d-none d-sm-flex">
                <!-- Mediano y superior -->
                <div class="col-md-5">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:border-indigo-500 focus:ring-indigo-500" href="{{ route('login') }}">
                        ¿Ya tienes una cuenta?
                    </a>
                </div>

                <div class="col-md-5">
                    <button type="submit" class="px-4 py-2 text-sm font-medium mdkbtn-success focus:outline-none focus:ring focus:border-indigo-500 focus:ring-indigo-500 w-full">
                        Registrarme
                    </button>
                </div>
            </div>
        </form>
    </div>
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
