<x-visitor-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="modal mdkmodal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header" style="justify-content: center">
              <h5 class="modal-title" id="staticBackdropLabel">Medik te informa:</h5>
            </div>
            <div class="modal-body text-center">
                <p>Para disfrutar de la experiencia completa de Medik, recomendamos usarlo en un escritorio.</p>
                <img class="mx-auto" src="assets/work.webp" alt="trabajando" style="height: 15rem">
                <p class="mt-2">Estamos trabajando en la versión mobile</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" id="close-modal" class="mdkbtn-warning py-1 px-2" data-dismiss="modal">Lo comprendo</button>
            </div>
          </div>
        </div>
    </div>


    <div class="text-center mb-1">
        <!-- Manito saludona -->
        <span class="text-4xl">&#x1F44B;</span>

        <!-- Título -->
        <div class="flex justify-content-center align-content-center mt-2">
            <h1 class="text-2xl font-bold fs-4 text-gray-600 mt-3" style="padding-top: 0.13rem">
                Bienvenido a 
            </h1>
            <!-- Logo Medik -->
            <x-logo-full fill-1="#18CCAB" fill-2="#0F0E4B" class="ml-1" width="100" height="50"/>
        </div>

        <!-- Descripción -->
        <p class="text-gray-600 mt-2">Inicia sesión con tu cuenta para acceder a la plataforma</p>
    </div>

    
    <form class="w-full sm:max-w-lg mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-600 ">Correo Electrónico</label>
            <input id="email" placeholder="email@example.com" class="form-control focus:border-indigo-500 focus:ring-indigo-500 shadow-sm block mt-1 w-full" type="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
            <div class="mt-2 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-600">Contraseña</label>
            <div>
                <input id="password" placeholder="••••••••" class="form-control focus:border-indigo-500 focus:ring-indigo-500 shadow-sm block mt-1 w-full" type="password" name="password" required autocomplete="current-password">
                <span id="togglePassword" class="fas fa-eye-slash field-icon"></span>
            </div>
            @error('password')
            <div class="mt-2 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me and Password Recovery-->
        <div class="flex justify-content-between align-content-center mb-3">
            <!-- Recuerdame... hoy me tengo que ir mi amor, recuerdame -->
            <div class="flex justify-content-center align-content-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <!-- Password Request-->
            <div>
                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
            </div>
        </div>        

        <div class="flex flex-col justify-content-between align-items-center mt-4 d-block d-sm-flex">
            <div class="col-12">
                <button class="px-4 py-2 mdkbtn-success rounded-md focus:outline-none focus:ring focus:ring-indigo-500 w-full">
                    Iniciar sesión
                </button>
            </div>

            <div class="col-12 mt-2 text-center">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:border-indigo-500 focus:ring-indigo-500" href="{{ route('register') }}">
                    ¿Aún no tienes una cuenta? Unete!
                </a>
            </div>
        </div>
    </form>
</x-visitor-layout>

<script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");

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

    /*Modal en mobile*/
    const closeModal = document.getElementById("close-modal");
    const modal = document.querySelector('.modal');

    function showMobileModal() {
        if (window.innerWidth < 768) {
            modal.style.display = 'block';
        } else {
            modal.style.display = 'none';
        }
    };

    // Mostrar el modal cuando se carga la página
    showMobileModal();

    // Mostrar el modal al cambiar el tamaño de la ventana
    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(showMobileModal, 350);
    });

    // Cerrar el modal
    closeModal.addEventListener("click", function () {
            modal.style.display = 'none';
    });
</script>
