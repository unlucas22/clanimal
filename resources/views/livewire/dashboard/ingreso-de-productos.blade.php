<x-slot name="title">Ingreso de Productos</x-slot>

<div class="py-4">
    <div>

        <div class="p-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Ingreso de Productos</h1>
        </div>

        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchTransfer" placeholder="Buscar">
                        </div>
                    </div>
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

                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                                    @foreach(['ID', 'Productos', 'Cantidad', 'Fecha de envío', 'Fecha de recepción', 'Estado'] as $key)
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
                                @php($td = 'p-4 text-base font-medium text-gray-900 dark:text-white')

                                @forelse($notifications as $notification)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="{{ $td }}">
                                        {{ $notification->id }}
                                    </td>
                                    <td class="{{ $td }}">
                                        @foreach($notification->product_for_transfers as $transfer)
                                        {{ $transfer->product_stocks->product_in_warehouses->products->name }},
                                        @endforeach
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $notification->stock_total }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $notification->fecha_envio_formatted }}
                                    </td>

                                    <td class="{{ $td }}">
                                        @if($notification->fecha_recepcion != null)
                                        {{ $notification->fecha_recepcion_formatted }}
                                        @endif
                                    </td>

                                    <td class="{{ $td }}">
                                        {!! $notification->status_formatted !!}
                                    </td>

                                    <td class="py-4 px-1 w-full block">

                                        <div class="flex justify-between gap-2" style="max-width: 250px;">
                                            <div>
                                                <a href="{{ route('dashboard.show.transfer', ['hashid' => $notification->hashid]) }}">
                                                <x-btn /></a>
                                            </div>
                                            @if($notification->status == 'en proceso')
                                            <div>
                                                <button onclick="callMarcarComoRecibidoButton({{ $notification->id }})" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Marcar como recibido</button>
                                            </div>

                                            <div>
                                                <button onclick='Livewire.emit("openModal", "modal.update.transfer", @json(["item_id" => $notification->id]))' type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                    Cancelar
                                                </button>
                                            </div>
                                            @endif
                                            
                                        </div>
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="8" class="py-3 italic">No hay Notificaciones</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                    <script>
                        function callMarcarComoRecibidoButton(item_id) {
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "Una vez que actualizas el estado no lo podrás retornar a su estado original",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, confirmar'
                            }).then(function (res) {
                                if (res.isConfirmed) {
                                    Livewire.emit('marcarComoRecibido', item_id);

                                    Livewire.emit('refreshComponent');
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>