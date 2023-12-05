<x-app-layout>

<x-slot name="head">
    @php($public_key = '6Lf391shAAAAAEij46zNjIHm2O8e6oYXPP56Llzk')
    <!-- recaptcha -->
    <script type="text/javascript">
        var onloadGReCaptcha = function() {
            grecaptcha.render('recaptcha', {
                'sitekey' : '{{ $public_key }}',
                'theme' : 'default'
            });
        };
    </script>
</x-slot>

    <div class="flex flex-col items-center justify-center px-6 mx-auto md:h-screen dark:bg-gray-900">
        
        <a href="{{ url('/') }}" class="flex items-center justify-center text-2xl font-semibold dark:text-white">
            <x-logo :width="'300'" :height="'200'" />
        </a>

        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Iniciar sesión en el sistema 
            </h2>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">

                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo electroncio</label>
                    <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="nombre@gmail.com" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                    <input type="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" name="password" required autocomplete="current-password">
                </div>

                <div class="mt-4 flex justify-center">
                    <div id="recaptcha" style="max-width: 300px;"></div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" name="remember">
                    </div>
                    <div class="ml-3 text-sm">
                    <label for="remember" class="font-medium text-gray-900 dark:text-white">Recuerdame</label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">¿Perdiste tu contraseña?</a>
                    @endif
                </div>
                <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Iniciar sesión</button>
            </form>
        </div>

        @if(!Cookie::has('qr_validation'))
        <div class="py-4">
            <a href="{{ route('control') }}"><button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full">Control de Colaboradores</button></a>
        </div>
        @endif

    </div>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadGReCaptcha&render=explicit&?hl=es" async defer></script>

</x-app-layout>
