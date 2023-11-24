<div>
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
                    <input wire:model="search" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar..." required>
                    <button wire:click="buscarProductos" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                </div>
            </div>

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
                                    Precio con IGV
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descuento
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Precio Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            @forelse($product->product_details as $product_detail)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $product->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $product_detail->product_presentations->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${{ $product_detail->precio_venta_con_igv }}
                                    </td>
                                    <td class="px-6 py-4">
                                        %{{ $product_detail->discount }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div style="max-width: 75px;">
                                            <input type="number" name="amount_{{ $product_detail->id }}" id="amount-{{ $product_detail->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" max="{{ $product_detail->amount }}" min="1" value="1" onchange="sumTotalFromAmount({{ $product_detail->id }}, {{ $product_detail->descuento() }})">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        $<span id="total-from-amount-{{ $product_detail->id }}">{{ $product_detail->descuento() }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <button type="button" onclick="Livewire.emit('agregarProducto', {{ $product_detail->id }}, document.getElementById('amount-{{ $product_detail->id }}').value)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar</button>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="7" class="py-3 italic">No hay Productos agregados</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <script>
                    function sumTotalFromAmount(id, precio)
                    {

                        let total = 0;

                        let cantidad = document.getElementById('amount-'+id).value;

                        /* se suma ya con el descuento aplicado */
                        for (var i = 0; i < cantidad; i++) {
                            total += precio;
                        }

                        document.getElementById('total-from-amount-'+id).innerHTML = total;
                    }
                </script>

            </div>

        </div>
        <div class="w-full">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Compras realizadas
                </h2>
            </div>

            <div class="flex justify-between pt-4 gap-8">
                <div class="w-full">
                    <div>
                        <label for="default-search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Agregar Texto" wire:model.defer="dni" name="dni" min="8" max="8">
                            <a class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer" wire:click="searchClient">Buscar</a>
                        </div>
                        @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="pt-6">
                    <a href="{{ route('dashboard.create.client') }}" target="_blank"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Nuevo Cliente</button></a>
                </div>
            </div>

            <form wire:submit.prevent="submit" class="space-y-10">
                @csrf

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <x-form.input :label="'Cliente'" :name="'client_name'" :model="'client_name'" :placeholder="'Buscar primero por DNI'" :required="'disabled'" />
                    </div>

                    <div class="w-full">  
                        <label for="ss2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mascota</label>
                        <select id="ss2" name="pet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="pet_id">
                            @forelse($pets as $pet)
                            <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @empty
                            <option value="0">Sin mascotas registradas.</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div>
                    <div>Productos:</div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Producto
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Precio unidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos_para_compra as $producto)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $producto->product_details->products->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            ${{ $producto->product_details->precio_venta_con_igv }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $producto->cantidad ?? 1 }}
                                        </td>

                                        <td class="px-6 py-4">
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

                <div>
                    <label class="relative inline-flex items-center mb-5 cursor-pointer">
                        <input type="checkbox" wire:model="factura" name="active" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Factura</span>
                    </label>
                </div>

                @if($factura)

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <x-form.input :label="'Número de RUC'" :name="'client_ruc'" :model="'client_ruc'" :placeholder="'RUC'" :required="'required'" />
                    </div>
                    <div class="w-full">
                        <x-form.input :label="'Razón Social'" :name="'client_razon_social'" :model="'client_razon_social'" :placeholder="''" />
                    </div>
                </div>

                @endif

                <div>
                    <div class="mb-4">Metodo de Pago</div>

                    <div class="grid grid-cols-3 gap-4">
                        
                        <div class="flex items-center mb-4">
                            <input checked id="default-radio-1" type="radio" value="" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Efectivo</label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" type="radio" value="" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tarjeta de Debito/Credito</label>
                        </div>

                        <div class="flex items-center">
                            <input id="default-radio-2" type="radio" value="" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yape/Plin/QR</label>
                        </div>

                    </div>
                </div>

                <div>
                    <x-form.input :label="'Vendedor Referente'" :name="'user_referente'" :model="'user_referente'" :placeholder="'(opcional)'" />
                </div>

                <div>Realizar el cobro de los productos antes de procesar el pago.</div>


                <div class="flex justify-between gap-8">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            S/ {{ $total }} Soles
                        </h2>
                    </div>
                    <div>
                        <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Procesar Pago</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
