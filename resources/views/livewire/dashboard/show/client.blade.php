<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between">
        <div class="flex justify-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cliente  #{{ $client->id }} {{ $client->name }}
            </h2>
        </div>
        <div class="flex justify-end">
            <button onclick="window.history.back();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</button>
        </div>
    </div>

</x-slot>

<div>
@php($sd = 'w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150')

    <div class="bg-white shadow rounded-lg w-5/6 md:w-5/6  lg:w-4/6 xl:w-3/6 mx-auto">
        <div class="mt-16">
            <div class="flex justify-end"><p class="text-center text-sm text-gray-400 font-medium pt-4">{!! $client->reports->formatted_status !!}</div>
            <h1 class="font-bold text-center text-3xl text-gray-900 pt-8">{{ $client->name }}</h1>
            </p>

            <div class="flex justify-between items-center my-5 px-6 pt-8">
                @if(Auth::user()->isAdmin())
                <a href="" class="text-gray-500 hover:text-gray-900 bg-blue-50 hover:bg-blue-100 rounded transition duration-150 ease-in font-medium text-sm text-center w-full py-3">Analytics</a>
                @endif
                <a href="#" class="text-gray-800 hover:text-black bg-yellow-300 hover:bg-yellow-200 rounded transition duration-150 ease-in font-medium text-sm text-center w-full py-3">Añadir Mascota</a>
            </div>

            <div class="w-full pt-8">
                <h3 class="font-medium text-gray-900 text-left px-6"><span class="text-lg font-semibold">Información.</span></h3>
                <div class="mt-5 w-full flex flex-col items-center overflow-hidden text-sm">
                    <a href="mailto:{{ $client->email }}" class="{{ $sd }}">
                        <x-icons.svgrepo.arrow-right :class="'rounded-full h-6 w-6 shadow-md inline-block mr-2'" />
                            <strong>Email:</strong>: {{ $client->email }}
                    </a>
                    <a href="tel:{{ str_replace(' ', '', $client->phone) }}" class="{{ $sd }}">
                        <x-icons.svgrepo.arrow-right :class="'rounded-full h-6 w-6 shadow-md inline-block mr-2'" />
                            <strong>Teléfono:</strong> {{ $client->phone }}
                    </a>
                    <a href="#" class="{{ $sd }}">
                        <x-icons.svgrepo.arrow-right :class="'rounded-full h-6 w-6 shadow-md inline-block mr-2'" />
                            <strong>Registrado por:</strong> {{ $client->users->name }}
                    </a>
                </div>
            </div>

            <div class="w-full pt-8">
                <h3 class="font-medium text-gray-900 text-left px-6"><span class="text-lg font-semibold">Mascotas.</span> <em>En total: {{ count($pets) }}</em></h3>
                <div class="mt-5 w-full flex flex-col items-center overflow-hidden text-sm">
                    @for($i=0; $i < count($pets); $i++)
                    
                    <div class="flex justify-end gap-14 py-4">
                        <div class="flex justify-start">
                            <h3 class="text-xl font-semibold">Mascota: {{ $pets[$i]->name }}</h3>
                        </div>
                        <div class="flex justify-end gap-8">
                            <div>
                                <a href="{{ route('dashboard.create.pet-images', ['hashid' => $pets[$i]->hashid]) }}"><button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Añadir imagenes</button></a>
                            </div>
                        </div>
                    </div>

                    @php($columns = ['Tipo de Mascota' => $pets[$i]->type_of_pets->name,'Sexo' => $pets[$i]->sex,'Edad' => $pets[$i]->age,'Altura' => $pets[$i]->height,'Peso' => $pets[$i]->weight,'Observación' => $pets[$i]->note])

                    @foreach($columns as $key => $value)
                        @if($value != null)
                            <p href="#" class="{{ $sd }}">
                                @switch($pets[$i]->type_of_pets->name)

                                    @case('Gato')
                                        <x-icons.svgrepo.cat :class="'rounded-full h-6 shadow-md inline-block mr-2 w-6'" />
                                    @break

                                    @case('Perro')
                                        <x-icons.svgrepo.dog :class="'rounded-full h-6 shadow-md inline-block mr-2 w-6'" />
                                    @break

                                    @case('Hamster')
                                        <x-icons.svgrepo.hamster :class="'rounded-full h-6 shadow-md inline-block mr-2 w-6'" />
                                    @break

                                    @case('Pájaro')
                                        <x-icons.svgrepo.bird :class="'rounded-full h-6 shadow-md inline-block mr-2 w-6'" />
                                    @break

                                    @default
                                        <x-icons.svgrepo.question :class="'rounded-full h-6 shadow-md inline-block mr-2 w-6'" />
                                    @break
                                @endswitch
                                    <strong>{{ $key }}:</strong> {{ $value }}
                            </p>

                        @endif
                    @endforeach
                        @if(count($pets[$i]->pet_photos))
                        <div class="p-4">
                            <div>IMAGENES</div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-4">
                                @forelse($pets[$i]->pet_photos as $photo)
                                    <div>
                                        <img src="{{ $photo->formatted_path }}">
                                    </div>
                                @empty
                                <div>No hay imagenes cargadas. <a href="#">Carga aqui</a></div>
                                @endforelse
                            </div>
                        </div>
                        @endif
                    @endfor

                    @if(!count($pets))
                    <p href="#" class="{{ $sd }}">
                        <x-icons.svgrepo.heart-broken :class="'rounded-full h-6 shadow-md inline-block mr-2 w-6'" />
                            Sin mascotas registradas
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

<!-- NO ELIMINAR
    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Ocasional</span>

    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Básico</span>

    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">VIP</span>

    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-indigo-900 dark:text-indigo-300">Sin definir</span>
-->
</div>
</x-app-layout>