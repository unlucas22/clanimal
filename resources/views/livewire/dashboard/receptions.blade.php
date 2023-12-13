<x-slot name="title">Recepción de Clientes y Mascotas</x-slot>

<div class="py-4">

    <div class="flex justify-end">
        <div class="flex justify-between gap-8 px-4">
            <div class="flex justify-start">
                <div><a href="{{ route('dashboard.create.client') }}">
                    <x-btn-nuevo :content="'Nuevo cliente'"/></a></div>
            </div>

            <div class="flex justify-start">
                <div><a href="{{ route('dashboard.create.shift') }}">
                    <x-btn-nuevo :content="'Nueva cita'"/></a></div>
            </div>
        </div>
        
    </div>

    {{-- CITAS --}}
    <div>
        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter1" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter1" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchShift" placeholder="Buscar">
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Lista de espera</h1>   
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>

                                @php($shifts_column = ['ID', 'Cliente', 'DNI', 'Teléfono', 'Mascota', 'Especialidad', 'Fecha de Atención', 'Estado'])

                                @php($colStyle = 'p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400')
                                    @foreach($shifts_column as $key)
                                    <th scope="col" class="{{ $colStyle }}">
                                        {{ $key }}
                                    </th>
                                    @endforeach
                                    <th scope="col" class="{{ $colStyle }}" style="max-width: 250px;">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @php($td = 'px-6 py-4')

                                @forelse($shifts as $shift)
                                <tr >
                                    <td class="{{ $td }}">
                                        {{ $shift->id }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $shift->pets->clients->name }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $shift->pets->clients->dni }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $shift->pets->clients->phone ?? '' }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $shift->pets->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $shift->services->name }}
                                    </td>

                                    {{-- ordenado por fecha desc --}}
                                    <td class="{{ $td }}">
                                        {{ $shift->appointment->format('H:i m/d') }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {!! $shift->formatted_status !!}
                                    </td>

                                    <td class="py-4 px-1 flex justify-center">

                                        <div class="flex justify-between gap-2">
                                            <div>
                                                <button wire:click='$emit("openModal", "modal.update.shift-status", @json(["item_id" => $shift->id, "status_id" => $shift->status]))' type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-1 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cambiar estado</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="{{ count($shifts_column)+1 }}" class="py-3 italic">No hay Citas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $shifts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notificaciones --}}
    <div class="pt-8">

        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter2" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter2" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchNotification" placeholder="Buscar">
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Notificaciones</h1>   
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>

                                @php($colStyle = 'p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400')
                                    @foreach(['ID', 'Cliente', 'DNI', 'Mascota', 'Especialidad', 'Fecha de Atención', 'Estado'] as $key)
                                    <th scope="col" class="{{ $colStyle }}">
                                        {{ $key }}
                                    </th>
                                    @endforeach
                                    <th scope="col" class="{{ $colStyle }}" style="max-width: 250px;">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @php($td = 'px-6 py-4')

                                @forelse($notifications as $notification)
                                <tr >
                                    <td class="{{ $td }}">
                                        {{ $notification->id }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $notification->pets->clients->name }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $notification->pets->clients->dni }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $notification->pets->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $notification->services->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $notification->delivery_at != null ? $notification->delivery_at->format('H:i m/d') : '' }}
                                    </td>

                                    <td class="{{ $td }}" style="min-width: 200px;">
                                        {!! $notification->formatted_status !!}
                                    </td>

                                    <td class="py-4 px-1 w-full block">

                                        <div class="flex justify-between gap-2" style="max-width: 250px;">
                                            <div>
                                                <a target="_blank" href="https://api.whatsapp.com/send/?phone={{ $notification->pets->clients->phone }}" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center me-2 mb-2">
                                                    <x-icons.svgrepo.whatsapp :class="'w-4 h-4 me-2'" />
                                                    Whatsapp
                                                </a>
                                            </div>
                                            <div>
                                                <button wire:click="marcarComoEntregado({{ $notification->id }})" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Marcar como entregado</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="{{ count($shifts_column)+1 }}" class="py-3 italic">No hay Notificaciones</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>