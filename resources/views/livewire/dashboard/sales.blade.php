<x-slot name="title">Recepción de Clientes y Mascotas</x-slot>

<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-between w-full mb-1">
            
            <div class="mb-4">
                <h1 class="text-xl mt-3 font-semibold text-gray-900 sm:text-2xl dark:text-white">Gestión de Ventas</h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex justify-end">
                    <div class="flex justify-between gap-8 px-4">
                        <div class="flex justify-start">
                            <div><a href="{{ route('dashboard.venta.productos') }}">
                                <x-btn-nuevo/></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>

                                @php($shifts_column = ['ID', 'Cliente', 'DNI','Servicios', 'Valor de Venta', 'IGV', 'Monto total', 'Fecha'])
                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                                    @foreach(['ID', 'Cliente', 'DNI', 'Metodo de Pago', 'Productos/Servicios', 'Total', 'En Caja', 'Fecha de Atención'] as $key)
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
                            @php($td = 'px-2 py-4')

                            @forelse($notifications as $notification)
                            <tr >
                                <td class="{{ $td }}">
                                    {{ $notification->id }}
                                </td>
                                <td class="{{ $td }}">
                                    {{ $notification->clients->name }}
                                </td>
                                <td class="{{ $td }}">
                                    {{ $notification->ruc ?? $notification->clients->dni }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $notification->metodo_de_pago_formatted }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $notification->product_for_sales_count }}
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $notification->total }} Soles
                                </td>

                                <td class="{{ $td }}">
                                    {{ $notification->users->name }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $notification->created_at->format('d/m/Y h:i A') }}
                                </td>
                                
                                <td class="py-4 px-1 w-full block">
                                    <div>
                                        <a href="{{ route('dashboard.show.venta.factura', ['bill_id' => $notification->id]) }}"><x-btn /></a>
                                    </div>
                                </td>
                            </tr class="bg-white border-b">
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="{{ count($shifts_column)+1 }}" class="py-3 italic">No hay Ventas</td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CITAS --}}
    <div class="pt-8">
        <div class="mb-4 p-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Procesar pago de servicios veterinarios</h1>   
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
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

                                @forelse($sales as $sale)
                                <tr >
                                    <td class="{{ $td }}">
                                        {{ $sale->id }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $sale->clients->name }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $sale->clients->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        @forelse($sale->presales as $presale)
                                        {{ $presale->description }} -
                                        @empty
                                        sin productos
                                        @endforelse
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ $sale->total }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ $sale->total * 0.18 }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        S/ {{ ($sale->total * 0.18) + $sale->total }} Soles
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $sale->created_at->format('d/m/Y h:i A') }}
                                    </td> 

                                    <td class="py-4 px-1 flex justify-center">

                                        <div class="flex justify-between gap-2">
                                            <div>
                                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Procesar Pago (FALTA ESTO)</button>
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
            </div>
        </div>
    </div>
</div>