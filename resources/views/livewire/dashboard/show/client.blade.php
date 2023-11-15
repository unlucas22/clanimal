<div>

    <div class="flex justify-between gap-8">
        <div class="w-full">
            <div class="flex justify-center gap-4">
                
                <div><img class="w-24 h-24 rounded" src="{{ asset('img/profile-client.png') }}"></div>

                <div>
                    <div class="flex justify-between w-full gap-8 pt-4">
                        <div><h1 class="font-bold text-center text-3xl text-gray-900 w-full">{{ $client->name }}</h1></div>
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

        <div class="flex justify-between gap-8">
            <div>
                <h3 class="font-medium text-gray-900 text-left"><span class="text-lg font-semibold">Mascotas ({{ count($pets) }})</span></h3>

                <div class="mt-5 w-full grid grid-cols-2 overflow-hidden text-sm">
                    @for($i=0; $i < count($pets); $i++)


                    <div class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" style="min-width: 300px;">

                        <div class="grid grid-cols-4">
                            <div class="w-20 h-20">
                                @forelse($pets[$i]->pet_photos as $photo)
                                    @if($photo->first)
                                        <a href="{{ route('dashboard.create.pet-images', ['hashid' => $pets[$i]->hashid]) }}"><img class="w-20 h-20" src="{{ $photo->formatted_path }}"></a>
                                    @endif
                                @empty
                                <a href="{{ route('dashboard.create.pet-images', ['hashid' => $pets[$i]->hashid]) }}"><img class="w-full" src="{{ asset('img/blank-photo.jpg') }}"></a>
                                @endforelse
                            </div>
                            
                            <div class="p-4 text-left col-span-3">
                                <h3 class="text-xl font-semibold ">{{ $pets[$i]->name }}</h3>
                                <div>
                                    {{ $pets[$i]->type_of_pets->name }}, {{ $pets[$i]->gender }}, {{ $pets[$i]->age }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor

                    @if(!count($pets))
                    <p>Sin mascotas registradas</p>
                    @endif
                </div>
                <div class="pt-8">
                    <a href="{{ route('dashboard.create.pet', ['hashid' => $client->hashid]) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">Añadir Mascota</a>
                </div>
            </div>

            {{-- Tabla de prueba, despues se mueve a un componente individual --}}
            <div>
                <h3 class="font-medium text-gray-900 text-left"><span class="text-lg font-semibold">Compras o servicios</span></h3>

                <div class="flex justify-between gap-8 pt-4">
                    <div>
                        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
                        <div class="relative">
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
                    <div class="relative overflow-x-auto">
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
        </div>

    </div>

</div>