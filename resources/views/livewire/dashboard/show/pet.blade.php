<div class="p-6">
    
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Detalle de Mascota
        </h3>

        <x-btn-retorno-default />
    </div>

    <div class="mt-4 "><strong>Dueño:</strong></div>

    <div class="flex justify-between gap-8">
        <div class="w-full">
            <div class="flex justify-center gap-4">
                
                <div><img class="w-24 h-30 rounded" src="{{ asset('img/profile-client.png') }}"></div>

                <div>
                    <div class="flex justify-between w-full gap-8 pt-4">
                        <div><h1 class="font-bold text-3xl text-gray-900 w-full">{{ $client->name }}</h1></div>
                        <div><p class="text-center text-sm text-gray-400 font-medium pt-4 w-full">{!! $client->reports->formatted_status !!}</p></div>
                    </div>

                    <div class="pt-4">
                        <div><strong>DNI:</strong> {{ $client->dni ?? '' }}</div>
                        <div><strong>Dirección:</strong> {{ $client->address ?? '' }}</div>
                    </div>

                </div>
                
            </div>
        </div>
        <div class="w-full">
            <div class="flex justify-center gap-8">
                <div><a type="button" href="tel:{{ $client->phone }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 inline-flex items-center">
                    <x-icons.heroicons.phone :class="'w-4 h-4 me-2'" />

                    {{ $client->phone }}</a></div>

                <div><a target="_blank" href="https://api.whatsapp.com/send/?phone={{ $client->phone }}" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center me-2 mb-2">
                    <x-icons.svgrepo.whatsapp :class="'w-4 h-4 me-2'" />
                    Whatsapp
                </a></div>

                <div><a type="button" href="mailto:{{ $client->email }}" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 inline-flex items-center me-2 mb-2">
                    <x-icons.heroicons.mail :class="'w-4 h-4 me-2'" />
                Correo
            </a></div>
            </div>
        </div>
    </div>

    <div class="w-full pt-8">

        <div class="flex justify-between gap-8 pt-4">
            <div class="w-full">
                <div class="flex justify-between">
                    <div class="flex justify-start">
                        <h3 class="font-medium text-gray-900 text-left text-2xl"><span class="text-lg font-semibold">Información de Pelusa</span></h3>
                    </div>
                    <div class="flex justify-end">
                        <button wire:click='$emit("openModal", "modal.qr.pet", @json(["pet_hashid" => $pet->hashid]))' type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 me-2 mb-2">
                            <x-icons.heroicons.qr :class="'w-4 h-4 me-2'" />
                            Imprimir QR
                        </button>
                    </div>
                </div>

                <div class="mt-5 w-full grid grid-cols-2 overflow-hidden text-sm">

                    <div class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="min-width: 300px;">

                        <div class="grid grid-cols-4">
                            <div class="w-20 h-20">
                                @forelse($pet->pet_photos as $photo)
                                    <a href="{{ route('dashboard.create.pet-images', ['hashid' => $pet->hashid]) }}"><img class="w-20 h-20" src="{{ $photo->formatted_path }}"></a>
                                @empty
                                <a href="{{ route('dashboard.create.pet-images', ['hashid' => $pet->hashid]) }}"><img class="w-full" src="{{ asset('img/blank-photo.jpg') }}"></a>
                                @endforelse
                            </div>
                            
                            <div class="p-4 text-left col-span-3">
                                <h3 class="text-xl font-semibold ">{{ $pet->name }}</h3>
                                <div>
                                    {{ $pet->type_of_pets->name }}, {{ $pet->gender }}, {{ $pet->age }}, {{ $pet->weigth }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="pt-8">

                    <div class="mb-4">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                        <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="note" placeholder="">{{ $pet->note }}</textarea>
                    </div>                        

                    <button wire:click="updateNote" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">Guardar</button>

                </div>
            </div>

            <div class="w-full">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white text-center">Imagenes de {{ $pet->name }}</h2>

                    <div class="flex justify-center">
                        
                        <div class="grid grid-cols-3 gap-2" id="files-boxs" style="max-width: 350px;">
                            @for($i=0; $i < count($pet_photos); $i++)
                            <div class="">
                                <img class="h-auto rounded-lg" onclick="showModal('{{ $photo->formatted_path }}')" src="{{ $pet_photos[$i]->formatted_path }}">
                            </div>
                            @endfor
                        </div>

                        @if(count($pet_photos) == 0)
                        <div class="pt-2">No hay Imagenes</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- The Modal -->
    <div id="modal"
        class="hidden fixed top-0 left-0 z-80 w-screen h-screen bg-black/70 flex justify-center items-center">

        <!-- The close button -->
        <a class="fixed z-90 top-6 right-8 text-white text-5xl font-bold" href="javascript:void(0)"
            onclick="closeModal()">&times;</a>

        <!-- A big image will be displayed here -->
        <img id="modal-img" class="max-w-[800px] max-h-[600px] object-cover" />
    </div>

    <script>
        // Get the modal by id
        var modal = document.getElementById("modal");

        // Get the modal image tag
        var modalImg = document.getElementById("modal-img");

        // this function is called when a small image is clicked
        function showModal(src) {
            modal.classList.remove('hidden');
            modalImg.src = src;
        }

        // this function is called when the close button is clicked
        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>

{{-- 
    <div class="w-full pt-8">
        <h3 class="font-medium text-gray-900 text-left"><span class="text-lg font-semibold">Servicios y productos contratados para {{ $pet->name }}</span></h3>

        <div class="flex justify-between gap-8 pt-4">
            <div class="relative">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
                <div class="">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar" required>
                </div>

            </div>
            <div class="p-2">
                Total Historico: S/0 Soles
            </div>
        </div>

        <div class="pt-4">
            <div class=" overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Especialidad
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Monto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
     --}}

</div>