<div>

    <div class="p-4">
        
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Salida de Producto
            </h3>

            <x-btn-retorno-default />
        </div>
    </div>
    
    {{-- Informacion de la compra --}}
    <div class="flex justify-between p-4 text-xl">

        {{-- PRIMERA FILA --}}
        <div class="space-y-10">
            <div class="flex justify-between gap-8">
                <div class="font-bold">Destino</div>
                <div>
                    {{ $transfer->companies->name }}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">Enviado Por:</div>
                <div>
                    {{ $transfer->users->name }}
                </div>
            </div>
        </div>

        {{-- SEGUNDA FILA --}}
        <div class="space-y-10">
            <div class="flex justify-between gap-8">
                <div class="font-bold">Fecha de envío:</div>
                <div>
                    {{ $transfer->fecha_envio->format('Y-m-d') }}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">Fecha de Recepción:</div>
                <div>
                    @if($transfer->fecha_recepcion !== null)
                    {{ $transfer->fecha_recepcion->format('Y-m-d') }}
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-10">

            <div class="flex justify-between gap-8">
                <div class="font-bold">Estado:</div>
                <div>
                    {!! $transfer->status_formatted !!}
                </div>
            </div>

            @if($transfer->status == 'cancelado')
            <div class="flex justify-between gap-8">
                <div class="font-bold">Motivo:</div>
                <div>
                    {{  $transfer->motivo }}
                </div>
            </div>
            @endif

            @if($transfer->status == 'en proceso')
            <div class="flex justify-between gap-8">
                <div class="font-bold">Cambiar estado:</div>
                <div>
                    <button onclick='Livewire.emit("openModal", "modal.update.transfer", @json(["item_id" => $transfer->id]))' type="button" id="deleteProductButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        Cancelar
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="pt-8">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    @php($colStyle = 'p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400')
                                    @foreach(['Producto', 'Cantidad', 'Presentación', 'Precio Venta sin IGV', 'Descuento %', 'Precio Venta Total'] as $key)
                                    <th scope="col" class="{{ $colStyle }}">
                                        {{ $key }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                            @php($td = 'p-4 text-base font-medium text-gray-900 dark:text-white')

                            @forelse($products as $product)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <td class="{{ $td }}">
                                    {{ $product->name }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->product_details[0]->amount }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->product_details[0]->product_presentations->name }}
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $product->product_details[0]->precio_venta_sin_igv }} Soles
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $product->product_details[0]->discount }} Soles
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $product->precio_venta_total }} Soles
                                </td>

                            </tr class="bg-white border-b">
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="4" class="py-3 italic">No hay Productos</td>
                            </tr>
                            @endforelse    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(count($products) > 8)
            <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
