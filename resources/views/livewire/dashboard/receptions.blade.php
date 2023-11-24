<x-slot name="title">Recepción de Clientes y Mascotas</x-slot>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Recepción de Clientes y Mascotas
    </h2>
</x-slot>

<div class="py-4">

    <div class="px-2">
        Módulo para el registro de clientes, programación de citas y servicios
    </div>

    <div class="flex justify-end">
        <div class="flex justify-between gap-8 px-4">
            <div class="flex justify-start">
                <a href="{{ route('dashboard.create.client') }}">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Nuevo Cliente
                    </button>
                </a>
            </div>

            <div class="flex justify-start">
                <a href="{{ route('dashboard.create.shift') }}">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Nueva Cita
                    </button>
                </a>
            </div>
        </div>
        
    </div>

    {{-- CITAS --}}
    <div>
        <h3 class="px-2 font-bold text-2xl text-gray-800 leading-tight">
            Lista de espera
        </h3>

        <div class="relative overflow-x-auto sm:overflow-hidden mt-10 sm:mt-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                    <tr>

                    @php($shifts_column = ['ID', 'Cliente', 'DNI', 'Teléfono', 'Mascota', 'Especialidad', 'Fecha de Atención', 'Estado'])

                    @php($colStyle = 'px-6 py-4')
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
        </div>
    </div>

    {{-- Notificaciones --}}
    <div class="pt-8">
        <h3 class="px-2 font-bold text-2xl text-gray-800 leading-tight">
            Notificaciones
        </h3>

        <div class="relative overflow-x-auto sm:overflow-hidden mt-10 sm:mt-5">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                    <tr>

                    @php($colStyle = 'px-6 py-4')
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

                        {{-- 
                        <td class="{{ $td }}">
                            {{ $notification->pets->clients->phone ?? '' }}
                        </td>
                         --}}

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
                                
                                {{-- 
                                <div>
                                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Nueva Cita</button>
                                </div>
                                 --}}
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
        </div>
    </div>
</div>