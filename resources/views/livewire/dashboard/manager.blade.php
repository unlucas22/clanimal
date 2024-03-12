<div class="py-4">

    {{-- Ultimos ingresos --}}

    <div class="pt-4">
        <div class="mb-4 p-4">
            <div class="flex justify-between gap-8">
                <div></div>
                <div class="bg-white w-full  border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 p-6">
                    <div class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">En tienda</div>
                    <div class="text-3xl mb-4">S/ {{ $en_caja_del_dia }}</div>
                    <div class="text-xl font-semibold text-gray-900 dark:text-white"></div>
                </div>
                <div class="w-full  bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 p-6">
                    <div class="text-xl  mb-4 font-semibold text-gray-900 dark:text-white">Ingresos</div>
                    <div class="text-3xl mb-4">S/ {{ $ingresos_del_dia }}</div>
                </div>

                <div class="bg-white w-full border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 p-6">
                    <div class="text-xl mb-4 font-semibold text-gray-900 dark:text-white">Salida a Finanza</div>
                    <div class="text-3xl mb-4">S/ {{ $salidas_del_dia }}</div>
                    <div class="pt-4"><a wire:click='$emit("openModal", "modal.store.finance")'>
                        <x-btn-nuevo/>
                    </a>
                    </div>
                </div>
                <div></div>
            </div>
        </div>
    </div>

    <div>
        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter1" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter1" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchIngreso" placeholder="Buscar">
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Últimos Ingresos</h1>   
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

                                @php($shifts_column = ['ID', 'Fecha solicitud', 'Fecha de validación', 'Caja', 'Cajera', 'Monto Tarjeta', 'Monto Tarjeta Virtual', 'Monto Efectivo', 'En caja', 'Estado'])

                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
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

                                @forelse($ingresos as $ingreso)
                                <tr >
                                    <td class="{{ $td }}">
                                        {{ $ingreso->id }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $ingreso->closed_at->format('d/m/Y h:i A') }}
                                    </td>

                                    <td class="{{ $td }}">
                                        @if($ingreso->validated_at !== null)
                                        {{ $ingreso->validated_at->format('d/m/Y h:i A') }}
                                        @endif
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $ingreso->cashers->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $ingreso->cashers->users->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ $ingreso->total_tarjeta }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ $ingreso->total_virtual }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ $ingreso->total_efectivo }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ $ingreso->en_caja }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        {!! $ingreso->formatted_status !!}
                                    </td>

                                    <td class="py-4 px-1 flex justify-center">

                                        <div class="flex justify-between gap-2">
                                            <div>
                                                <a wire:click='$emit("openModal", "modal.update.ingreso", @json(["item_id" => $ingreso->id]))'>
                                                    <x-btn-nuevo :content="'Cambiar Estado'"/></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="{{ count($shifts_column)+1 }}" class="py-3 italic">No hay Ingresos</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $ingresos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sumarTotal()
        {
            let tarjetaValue = document.getElementById('monto_tarjetas').value;
            let efectivoValue = document.getElementById('monto_efectivo').value;

            // Convert the string values to numbers using parseFloat or parseInt
            let tarjeta = parseFloat(tarjetaValue) || 0; // Use 0 if parsing fails
            let efectivo = parseFloat(efectivoValue) || 0;

            // Perform the addition
            let total = tarjeta + efectivo;

            // Set the result in the monto_total element
            document.getElementById('monto_total').value = total;
        }
    </script>


    {{-- Notificaciones --}}
    <div class="pt-8">

        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter2" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter2" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchSalida" placeholder="Buscar">
                        </div>
                    </div>
                </div>
                <div class="flex justify-between gap-8 pt-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Últimas Salidas</h1>   
                    </div>
                    <div>
                        <a wire:click='$emit("openModal", "modal.store.finance")'>
                            <x-btn-nuevo/>
                        </a>
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
                                    @foreach(['ID', 'Fecha de reporte', 'Gerente de Tienda', 'Local', ' Monto Tarjeta', 'Monto Efectivo', 'Estado'] as $key)
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

                                @forelse($salidas as $salida)
                                <tr >
                                    <td class="{{ $td }}">
                                        {{ $salida->id }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $salida->reported_at->format('d/m/Y h:i A') }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $salida->users->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $salida->users->companies->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $salida->total_tarjetas ?? 0 }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $salida->total_efectivo ?? 0 }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {!! $salida->formatted_status !!}
                                    </td>

                                    <td class="py-4 px-1 w-full block">

                                        <div class="flex justify-center gap-2" style="max-width: 250px;">
                                            <div>
                                                <a wire:click='$emit("openModal", "modal.update.finance", @json(["item_id" => $salida->id]))'>
                                                    <x-btn/>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="{{ count($shifts_column)+1 }}" class="py-3 italic">No hay Salidas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $salidas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>