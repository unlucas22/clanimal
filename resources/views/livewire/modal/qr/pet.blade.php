<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Escanea el QR para obtener los datos de {{ $pet->name }}
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="space-y-4 p-4">

               <div>
                    <div class="flex justify-center">
                        <div class="p-2">
                            {!! DNS2D::getBarcodeHTML("{$link}", 'QRCODE') !!}
                        </div>
                    </div>

                    {{-- <a href="{{ $link }}">click aquí (link de prueba)</a> --}}
                </div>

                <hr>

                <div class="text-center">

                    <div><h2 class="mb-4 text-3xl tracking-tight font-semibold text-center text-gray-900 dark:text-white">{{ ucwords($pet->name) }} ({{ $pet->type_of_pets->name }})</h2></div>
                    <div>Detalles: {{ $pet->gender }}</div>

                    <div class="pt-4 flex justify-center gap-8">
                        <div class="font-semibold">Dueño: </div>
                        <div>{{ $pet->clients->name }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>    
</div>