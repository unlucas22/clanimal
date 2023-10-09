<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Cliente  #{{ $client->id }} {{ $client->name }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="py-0 sm:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold mb-4">Perfil de Cliente</h1>
                    
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-2">Información del Cliente</h2>
                        <p><strong>Nombre:</strong> {{ $client->name }}</p>
                        <p><strong>Email:</strong> {{ $client->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $client->phone }}</p>
                        <p><strong>Estado:</strong> {{ $client->status }}</p>
                    </div>

                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-2">Mascotas</h2>
                        <ul>
                            @for($i=0; $i < count($pets); $i++)
                            <li>
                                <div class="bg-gray-200 p-2 rounded-lg mb-2">
                                    <h3 class="text-lg font-semibold">Mascota {{ $i+1 }}</h3>
                                    <p><strong>Nombre de la Mascota:</strong> {{ $pets[$i]->name }}</p>
                                    <p><strong>Tipo de Mascota:</strong> {{ $pets[$i]->type_of_pets->name }}</p>
                                    <p><strong>Sexo:</strong> {{ $pets[$i]->sex }}</p>
                                    <p><strong>Edad:</strong> {{ $pets[$i]->age ?? '' }}</p>
                                    <p><strong>Altura:</strong> {{ $pets[$i]->height ?? '' }}</p>
                                    <p><strong>Peso:</strong> {{ $pets[$i]->weight ?? '' }}</p>
                                    <p><strong>Observación:</strong> {{ $pets[$i]->note ?? 'Sin nota' }}</p>
                                </div>
                            </li>
                            @endfor

                            @if(!count($pets))
                            <li>Sin mascotas registradas</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>