<x-guest-layout>

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

    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="dni" value="{{ __('DNI') }}" />
                <x-jet-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required autofocus autocomplete="dni" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Correo electronico') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4 flex justify-center">
                <div id="recaptcha" style="max-width: 300px;"></div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya estas registrado?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Registrarse') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadGReCaptcha&render=explicit&?hl=es" async defer></script>
</x-guest-layout>
