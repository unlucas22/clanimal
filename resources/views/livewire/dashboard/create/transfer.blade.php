<div class=" p-4">

    <div>
        
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Salida de Productos
            </h3>

            <x-btn-retorno-default />
        </div>
    </div>

    <div class="flex justify-between gap-8">
        <div class="w-full">
            
            <div>
                
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input wire:model.debounce.300ms="search" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar..." required minlength="8" maxlength="8">
                    <button wire:click="buscarProductos" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                </div>
            </div>

            @if(count($products) != 0)
            @if(isset($products[0]->products))
            <div class="pt-8">
                <div>Productos encontrados:</div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Presentación
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Fecha de Vencimiento
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{-- Acciones --}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)

                            @if(isset($product->products))

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white" style="max-width:200px;">
                                    {{ $product->products->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $product->product_presentations->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->fecha_de_vencimiento != null)
                                    {{ $product->fecha_de_vencimiento }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div style="max-width: 75px;">
                                        <input type="number" name="amount_{{ $product->product_stocks[0]->id }}" id="amount-{{ $product->product_stocks[0]->id }}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" max="{{ $product->product_stocks[0]->stock }}" min="1" value="1" oninput="handleInputChange(this)">
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <button type="button" onclick="Livewire.emit('agregarProducto', {{ $product->product_stocks[0]->id }}, document.getElementById('amount-{{ $product->product_stocks[0]->id }}').value);" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar</button>
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="7" class="py-3 italic">No hay Productos agregados</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            @endif
            @endif

            <script>
            // Función que se llama cuando cambia el valor del input
            function handleInputChange(input) {
                // Obtener el valor actual del input
                var currentValue = parseFloat(input.value);

                // Obtener el valor máximo permitido para este input
                var maxLimit = parseFloat(input.getAttribute('max'));

                // Verificar si el valor actual excede el límite máximo
                if (currentValue > maxLimit)
                {
                    input.value = maxLimit;
                }
            }
        </script>

        </div>
        <div class="w-full">
            @if($errors->any())
            <div class="text-center text-red-500 font-semibold pb-4">
                <h4>{{$errors->first()}}</h4>
            </div>
            @endif
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Productos a Enviar
                </h2>
            </div>

            <form wire:submit.prevent="submit" class="space-y-10">
                @csrf

                <input type="hidden" wire:model="productos_guardados" name="productos_guardados">

                <div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Producto
                                    </th>
                                    <th scope="col" class="px-1 text-center py-3">
                                        Presentación
                                    </th>
                                    <th scope="col" class="px-1 text-center py-3">
                                        Fecha de Vencimiento
                                    </th>
                                    <th scope="col" class="text-center py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos_para_compra as $producto)

                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white" style="max-width:100px;">
                                            {{ $producto->product_in_warehouses->products->name }}
                                        </th>

                                        <td class="px-1 text-center py-4">
                                            {{ $producto->product_in_warehouses->product_presentations->name }}
                                        </td>

                                        <td class="py-4 text-center">
                                            {{ $producto->product_in_warehouses->fecha_de_vencimiento }}
                                        </td>

                                        <td class="py-4 text-center">
                                            {{ $producto->stock }}
                                        </td>

                                        <td class="py-4">
                                            <button type="button" wire:click="retirarProductoParaCompra({{ $producto->id }})" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Retirar</button>
                                        </td>
                                    </tr>
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="7" class="py-3 italic">No hay Productos o Stock disponible</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

                <div >
                    <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de envío</label>
                    <div class="relative max-w-sm">
                      <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                         <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                          </svg>
                      </div>
                      <input datepicker datepicker-format="mm/dd/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="datepicker" placeholder="Seleccionar Fecha" name="fecha" id="fecha" value="{{ date('m/d/Y') }}" {{-- wire:model.defer="fecha_envio"  --}} required onchange="handler(event);">
                    </div>
                </div>

                <div class="w-full">
                    <x-form.select :name="'company_id'" :model="'company_id'" :label="'Destino Sede'">
                        @forelse($sedes as $sede)
                        <option @if($loop->first) selected @endif value="{{ $sede->id }}">{{ ucwords($sede->name) }}</option>
                        @empty
                        <option>Error.</option>
                        @endforelse
                    </x-form.select>
                </div>

                <div class="flex justify-between gap-8">
                    <div>
                        <button class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Guardar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>