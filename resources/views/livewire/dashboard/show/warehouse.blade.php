<div>

    <div class="p-4">
        
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Ingreso
            </h3>

            <x-btn-retorno-default />
        </div>
    </div>
    
    {{-- Informacion de la compra --}}
    <div class="flex justify-between p-4 text-xl">

        {{-- PRIMERA FILA --}}
        <div class="space-y-10">
            <div class="flex justify-between gap-8">
                <div class="font-bold">{{ ucwords($warehouse->key_type) }}:</div>
                <div>
                    {{ $warehouse->value_type }}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">Proveedor:</div>
                <div>
                    {{ $warehouse->suppliers->name }}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">RUC:</div>
                <div>
                    {{ $warehouse->suppliers->ruc }}
                </div>
            </div>
        </div>

        {{-- SEGUNDA FILA --}}
        <div class="space-y-10">
            <div class="flex justify-between gap-8">
                <div class="font-bold">Fecha:</div>
                <div>
                    {{ $warehouse->fecha->format('d/m/Y') }}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">Monto:</div>
                <div>
                    {!! $warehouse->total_formatted !!}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">Descuento:</div>
                <div>
                    {!! $warehouse->discount_formatted !!}
                </div>
            </div>

            <div class="flex justify-between gap-8">
                <div class="font-bold">Estado:</div>
                <div>
                    {!! $warehouse->status_formatted !!}
                </div>
            </div>

            @if($warehouse->status == 'cancelado')
            <div class="flex justify-between gap-8">
                <div class="font-bold">Motivo:</div>
                <div>
                    {{  $warehouse->motivo }}
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-10">
            <div class="flex justify-between gap-8">
                <div class="font-bold">Registrado Por</div>
                <div>
                    {{ $warehouse->users->name }}
                </div>
            </div>
            <div class="flex justify-between gap-8">
                <div class="font-bold">Hora de Registro</div>
                <div>
                    {{ $warehouse->created_at->format('d/m/Y h:i A') }}
                </div>
            </div>

            @if($warehouse->status != 'cancelado' && $warehouse->status != 'contado')
            <div class="flex justify-between">
                <div class="font-bold">Cambiar estado</div>
                <div>
                    <button onclick='Livewire.emit("openModal", "modal.update.warehouse", @json(["item_id" => $warehouse->id]))' type="button" id="deleteProductButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        Cancelar
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="pt-8">

        <div class="mb-4 p-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Productos</h1>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    @php($colStyle = 'p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400')
                                    @foreach(['Producto', 'Cantidad', 'Presentación', 'Precio Venta sin IGV', 'Descuento %', 'Precio Compra'] as $key)
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
                                    {{ $product->products->name }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->amount }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->product_presentations->name }}
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $product->precio_venta_sin_igv }} Soles
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $product->discount }} Soles
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ ($product->amount * $product->precio_venta_con_igv) - $product->discount }} Soles
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
