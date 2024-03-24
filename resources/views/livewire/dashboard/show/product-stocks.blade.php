<div>

    <div class="p-4">
        
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Stock
            </h3>

            <x-btn-retorno-default />
        </div>
    </div>
   
    {{-- Tabla de productos --}}
    <div class="pt-8">

        <div class="mb-4 p-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Lotes de Producto {{ $warehouse->product_in_warehouses[0]->products->name }}</h1>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    @php($colStyle = 'p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400')
                                    @foreach(['Lote N°', 'Proveedor', 'Id de Ingreso de Producto', 'Presentación' ,'Stock', 'Precio de Compra', 'Fecha de Compra', 'Fecha de Vencimiento'] as $key)
                                    <th scope="col" class="{{ $colStyle }}">
                                        {{ $key }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                            @php($td = 'p-4 text-base font-medium text-gray-900 dark:text-white')

                            @php($i = 1)

                            @forelse($products as $product)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <td class="{{ $td }}">
                                    {{ $i }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->warehouses->suppliers->name }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->warehouse_id }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->product_presentations->name }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->product_stocks[0]->stock }}
                                </td>

                                <td class="{{ $td }}">
                                    S/ {{ $product->precio_venta_con_igv }} Soles
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->warehouses->fecha_formatted }}
                                </td>

                                <td class="{{ $td }}">
                                    {{ $product->fecha_de_vencimiento }}
                                </td>

                            </tr class="bg-white border-b">

                            @php($i += 1)
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
