<div class="space-y-10">

    <div>
        <x-logo/>
        <h1 class="text-4xl font-bold text-center">Pelusa</h1>
    </div>
    <div class="flex justify-center">
        <div>

            @if($pet->pet_photos !== null)
                <img class="w-32 h-32 rounded" src="{{ $pet->pet_photos[0]->formatted_path }}">
            @else
            <img class="w-32 h-32 rounded" src="{{ asset('img/profile-client.png') }}">
            @endif
        </div>
    </div>
    <div>
        <div class="text-center">{{ $pet->type_of_pets->name }}, {{ $pet->gender }}, {{ $pet->age }}</div>
        <div class="font-bold pt-4">Dueño:</div>
        <div>{{ $client->name }}</div>
    </div>

    <div class="space-y-4">
        <div class="flex justify-between">
            <div class="font-bold">
                Telefono
            </div>
            <div>{{ $client->phone ?? '' }}</div> 
        </div>

        <div class="flex justify-between">
            <div class="font-bold">
                Correo
            </div>
            <div>{{ $client->email ?? '' }}</div> 
        </div>

        <div class="flex justify-between">
            <div class="font-bold">
                Ubicación
            </div>
            <div>{{ $client->address ?? '' }}</div> 
        </div>
    </div>

    <div class="flex justify-center">
        <div>
            <a target="_blank" href="https://api.whatsapp.com/send/?phone={{ $client->phone }}" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center me-2 mb-2">
            <x-icons.svgrepo.whatsapp :class="'w-4 h-4 me-2'" />
                Contactar por WhatsApp
            </a>
        </div>
    </div>
</div>