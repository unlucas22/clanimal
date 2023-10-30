<x-guest-layout>

    <x-slot name="head">
        {{-- 
    @php($public_key = '6Lf391shAAAAAEij46zNjIHm2O8e6oYXPP56Llzk')
    <script type="text/javascript">
        var onloadGReCaptcha = function() {
            grecaptcha.render('recaptcha', {
                'sitekey' : '{{ $public_key }}',
                'theme' : 'default'
            });
        };
    </script>
     --}}
    </x-slot>

    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-logo/>
        </x-slot>

        <div class="flex justify-end"><a href="{{ route('login') }}">
            <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-center inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2">
              <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>

              Retroceder
            </button></a>
        </div>

        <x-jet-validation-errors class="mb-4" />

         <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Control de Colaboradores</h2>
         <h3 class="mb-4 tracking-tight font-semibold text-center text-gray-900 dark:text-white">Ingresar su DNI para registrar su ingreso o salida de tienda.</h3>
         @if(Cookie::has('qr_validation'))
         <div class="flex justify-center">
             
            <div id="toast-default" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.147 15.085a7.159 7.159 0 0 1-6.189 3.307A6.713 6.713 0 0 1 3.1 15.444c-2.679-4.513.287-8.737.888-9.548A4.373 4.373 0 0 0 5 1.608c1.287.953 6.445 3.218 5.537 10.5 1.5-1.122 2.706-3.01 2.853-6.14 1.433 1.049 3.993 5.395 1.757 9.117Z"/>
                    </svg>
                    <span class="sr-only">Fire icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">¡Atención! Hace poco escaneaste el QR, no es necesario volverlo hacer.</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-default" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
         </div>
         @endif

        @livewire('control')
        
    </x-jet-authentication-card>
    {{-- 
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadGReCaptcha&render=explicit&?hl=es" async defer></script>  --}}
</x-guest-layout>
