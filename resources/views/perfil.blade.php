<x-guest-layout>

    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

         <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Control de Colaboradores</h2>

        @if(Cookie::has('qr_validation'))
         <h3 class="mb-4 tracking-tight font-semibold text-center text-green-900 dark:text-white">Se registró correctamente.</h3>

        @livewire('perfil', [
            'user_id' => Cookie::get('qr_validation')
        ])

        @else
        <h3 class="mb-4 tracking-tight font-semibold text-center text-green-900 dark:text-white">Para ver tu perfil primero debe escanear el QR.</h3>
        @endif

        <div class="flex justify-center">
            <a href="{{ route('control') }}"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cerrar</button></a>
        </div>
        
    </x-jet-authentication-card>
</x-guest-layout>
