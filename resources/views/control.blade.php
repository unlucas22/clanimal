<x-guest-layout>
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

        @livewire('control')
        
    </x-jet-authentication-card>

    @if(Cookie::has('qr_validation'))
    <script>
        window.onload = function(){
            Swal.fire({
                title: 'Control de Colaboradores registrado con éxito, no es necesario volverlo hacer.',
                icon: 'success',
                iconColor: 'green',
                timer: 2000,
                toast: true,
                position: 'top-right',
                timerProgressBar: true,
                showConfirmButton: false,
            });
        }
    </script>
    @endif
</x-guest-layout>
