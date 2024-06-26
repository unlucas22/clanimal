<div class="pt-8 p-4">

    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Ventas
        </h3>

        <div>
            <a href="{{ url('dashboard/sales') }}" type="button" class="text-white bg-[#24292F] hover:bg-[#24292F]/90 focus:ring-4 focus:outline-none focus:ring-[#24292F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 font-semibold cursor-pointer">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2">
                  <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>

                RETORNO
            </a>
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
                    <input wire:model.debounce.300ms="search" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar..." required>
                    <button wire:click="buscarProductos" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
                </div>
                <span id="mensaje-error-numero-dni" style="color: red;"></span>
            </div>

            <div class="pt-8">
            @if(count($ofertas) != 0)
                <div>Ofertas encontradas:</div>

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Titulo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descripción
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
                            @forelse($ofertas as $oferta)
                            @if(!isset($oferta->name))
                            @php($oferta = \App\Models\Pack::with('product_for_packs')->where('name', $oferta['name'])->first())
                            @endif
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row" class="px-3 py-4 font-medium text-gray-900 dark:text-white" style="max-width:200px;">
                                        {{ $oferta->name }}
                                    </td>
                                    <td scope="row" class="px-3 py-4 font-medium text-gray-900 dark:text-white" style="max-width:200px;">
                                        @forelse($oferta->product_for_packs as $pack)
                                        {{ $pack->products->name }}.
                                        @empty
                                        @endforelse
                                    </td>
                                    <td class="px-3 py-4">
                                        <div style="max-width: 75px;">
                                            <input type="number" name="oferta_{{ $oferta->id }}" id="oferta-{{ $oferta->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" min="1" value="1" oninput="sumTotalFromOferta( {{ $oferta->id }}, {{ $oferta->precio }})">
                                        </div>
                                    </td>

                                    <td class="px-3 py-4">
                                        S/ <span id="total-from-oferta-{{ $oferta->id }}">{{ $oferta->precio }}</span> Soles
                                    </td>
                                    <td class="px-3 py-4">
                                        <button type="button" onclick="Livewire.emit('agregarOferta', {{ $oferta->id }}, document.getElementById('oferta-{{ $oferta->id }}').value)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar</button>
                                    </td>
                                </tr>
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="7" class="py-3 italic">No hay Productos con Stock</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            <script>
                function sumTotalFromOferta(id, precio)
                {
                    let total = 0;

                    let cantidad = document.getElementById('oferta-'+id).value;

                    /* se suma ya con el descuento aplicado */
                    for (var i = 0; i < cantidad; i++) {
                        total += precio;
                    }

                    document.getElementById('total-from-oferta-'+id).innerHTML = total.toFixed(2);
                }
            </script>
            </div>

            <div class="pt-8">
            @if(count($products) != 0)
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
                                    Precio
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
                            @forelse($products as $product_stock)
                                
                                @php($product_detail = \App\Models\ProductDetail::where('product_id', $product_stock->product_stocks->product_in_warehouses->product_id)->where('product_presentation_id', $product_stock->product_stocks->product_in_warehouses->product_presentation_id)->first())
                                
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row" class="px-3 py-4 font-medium text-gray-900 dark:text-white" style="max-width:200px;">
                                        {{ $product_stock->product_stocks->product_in_warehouses->products->name }}
                                    </td>
                                    <td class="px-3 py-4">
                                        {{ $product_stock->product_stocks->product_in_warehouses->product_presentations->name }}
                                    </td>
                                    <td class="px-3 py-4">
                                        S/ {{ $product_detail->getPrecioDeOferta() ?? $product_stock->product_stocks->product_in_warehouses->precio_venta_con_igv }} Soles
                                    </td>
                                    <td class="px-3 py-4">
                                        @if($product_detail->getPrecioDeOferta() == null)
                                        S/ {{ $product_detail->discount ?? 0 }} Soles
                                        @else
                                        S/ 0 Soles
                                        @endif
                                    </td>
                                    <td class="px-3 py-4">
                                        <div style="max-width: 75px;">
                                            <input type="number" name="amount_{{ $product_stock->id }}" id="amount-{{ $product_stock->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" max="{{ $product_stock->stock }}" min="1" value="1" oninput="handleInputChange(this, {{ $product_stock->id }}, {{ $product_detail->getPrecioDeOferta() ?? $product_detail->precio_venta_con_igv - $product_detail->discount }})">
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        S/ <span id="total-from-amount-{{ $product_stock->id }}">{{ $product_detail->getPrecioDeOferta() ?? $product_detail->precio_venta_con_igv - $product_detail->discount }}</span> Soles
                                    </td>


                                    <td class="px-3 py-4">
                                        <button type="button" onclick="Livewire.emit('agregarProducto', {{ $product_detail->id }}, document.getElementById('amount-{{ $product_stock->id }}').value)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar</button>
                                    </td>
                                </tr>
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="7" class="py-3 italic">No hay Productos con Stock</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

                <script>
                    function sumTotalFromAmount(id, precio)
                    {
                        let total = 0;

                        let cantidad = document.getElementById('amount-'+id).value;

                        /* se suma ya con el descuento aplicado */
                        for (var i = 0; i < cantidad; i++) {
                            total += precio;
                        }

                        document.getElementById('total-from-amount-'+id).innerHTML = total.toFixed(2);
                    }

                    // Función que se llama cuando cambia el valor del input
                    function handleInputChange(input, id, precio) {
                        // Obtener el valor actual del input
                        var currentValue = parseFloat(input.value);

                        // Obtener el valor máximo permitido para este input
                        var maxLimit = parseFloat(input.getAttribute('max'));

                        // Verificar si el valor actual excede el límite máximo
                        if (currentValue > maxLimit)
                        {
                            input.value = maxLimit;
                        }

                        sumTotalFromAmount(id, precio);
                    }
                    function checkIsClientValid(event)
                    {
                        var input = document.getElementById("client-name").value;

                        // Verificar si el input está vacío
                        if (input.trim() === "") {
                            // Si está vacío, deshabilitar el botón de submit
                            return false;
                        }
                        return true;
                    }
                </script>

            </div>

        </div>
        <div class="w-full">
            @if($errors->any())
            <div class="text-center text-red-500 font-semibold pb-4">
                <h4>{{$errors->first()}}</h4>
            </div>
            @endif
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
                            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="DNI" wire:model.defer="dni" name="dni" minlength="8" maxlength="8" required>
                            <a class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer" wire:click="searchClient">Buscar</a>
                        </div>
                        @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="pt-6">
                    <a href="{{ route('dashboard.create.client') }}" target="_blank"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Nuevo Cliente</button></a>
                </div>
            </div>

            <form action="{{ route('dashboard.store.venta.productos') }}" onsubmit="return checkIsClientValid();" method="POST" class="space-y-10">
                @csrf

                <input type="hidden" wire:model="client_id" name="client_id">

                <input type="hidden" wire:model="productos_guardados" name="productos_guardados">
                <input type="hidden" wire:model="ofertas_guardados" name="ofertas_guardados">

                <input type="hidden" wire:model="igv" name="igv" value="0">
                <input type="hidden" wire:model="total" name="total" value="0">

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <x-form.input :label="'Cliente'" :name="'client_name'" :id="'client-name'" :model="'client_name'" :placeholder="'Buscar primero por DNI'" :required="'disabled onchange=checkIsClientValid()'" />
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
                                    <th scope="col" class="px-1 text-center py-3">
                                        Presentación
                                    </th>
                                    <th scope="col" class="px-1 text-center py-3">
                                        Precio unidad
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
                                            {{ $producto->product_details->products->name }}
                                        </th>
                                        <td class="py-4 text-center">
                                            {{ $producto->product_details->product_presentations->name }}
                                        </td>
                                        <td class="px-1 text-center py-4">
                                            ${{ $producto->product_details->getPrecioDeOferta() ?? $producto->product_details->descuento() }}
                                        </td>
                                        <td class="py-4 text-center">
                                            {{ $producto->cantidad ?? 1 }}
                                        </td>

                                        <td class="py-4">
                                            <button type="button" wire:click="retirarProductoParaCompra({{ $producto->id }})" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Retirar</button>
                                        </td>
                                    </tr>
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="7" class="py-3 italic">No hay Productos selecccionados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div>Ofertas:</div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Oferta
                                    </th>
                                    <th scope="col" class="px-1 text-center py-3">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-1 text-center py-3">
                                        Precio unidad
                                    </th>
                                    <th scope="col" class="text-center py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ofertas_para_compra as $oferta)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white" style="max-width:100px;">
                                            {{ $oferta->packs->name }}
                                        </th>
                                        <td class="px-1 text-center py-4">
                                            @forelse($oferta->packs->product_for_packs as $pack)
                                            {{ $pack->products->name }}.
                                            @empty
                                            @endforelse
                                        </td>
                                        <td class="px-1 text-center py-4">
                                            ${{ $oferta->packs->precio }}
                                        </td>
                                        <td class="py-4 text-center">
                                            {{ $oferta->cantidad ?? 1 }}
                                        </td>

                                        <td class="py-4">
                                            <button type="button" wire:click="retirarOfertaParaCompra({{ $oferta->id }})" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Retirar</button>
                                        </td>
                                    </tr>
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="7" class="py-3 italic">No hay Ofertas seleccionadas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <label class="relative inline-flex items-center mb-5 cursor-pointer">
                        <input type="checkbox" wire:model="factura" name="active" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">¿Desee emitir Factura?</span>
                    </label>
                </div>

                <div @class([
                    'hidden' => !$factura,
                    'block'
                ])>
                    

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <div>
                            <label for="cliente-ruc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de RUC</label>
                            <input type="text" name="cliente_ruc" id="cliente-ruc" wire:model="client_ruc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="RUC" @if($factura) required minlength="11" maxlength="11" oninput="validarInputRuc()" @endif>
                        </div>
                        <span id="mensaje-error-numero-ruc" style="color: red;"></span>
                    </div>
                    <div class="w-full">
                        <div>
                            <label for="client_razon_social" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Razón Social</label>
                            <input type="text" name="client_razon_social" id="client_razon_social" wire:model="client_razon_social" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Razón Social">
                        </div>
                    </div>
                </div>

                </div>

                <script>
                    function validarInputRuc() {
                      const input = document.getElementById('cliente-ruc');
                      const mensajeError = document.getElementById('mensaje-error-numero-ruc');

                      const regex = /^(10|20)\d*$/;

                      const valorInput = input.value;
                      
                      if (regex.test(valorInput)) {
                        mensajeError.textContent = '';
                      } else {
                        mensajeError.textContent = 'El RUC debe contener solo números y comenzar con 10 o 20.';
                      }
                    }
                </script>

                <div>
                    <div class="mb-4">Metodo de Pago</div>

                    <div class="flex justify-center gap-8">
                        
                        <div class="flex items-center">
                            <input checked id="default-radio-1" type="radio" wire:model="radio" value="efectivo" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Efectivo</label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" type="radio" value="tarjeta" wire:model="radio" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tarjeta de Debito/Credito</label>
                        </div>

                        <div class="flex items-center">
                            <input id="default-radio-3" type="radio" value="virtual" wire:model="radio" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yape/Plin/QR</label>
                        </div>

                        @if($client_linea_credito != null)

                        @if($total + $client_credito < $client_linea_credito)

                        <div class="flex items-center">
                            <input id="default-radio-4" type="radio" value="credito" wire:model="radio" name="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Crédito</label>
                        </div>
                        @endif
                        @endif

                    </div>
                </div>

                @if($radio == 'credito')
                @if($total + $client_credito < $client_linea_credito)
                <div>
                    <div class="mb-2">
                        Línea de Crédito
                    </div>
                    <div class="flex justify-between items-center gap-4 mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                          <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{  (($client_credito / $client_linea_credito) * 100) }}%"></div>
                        </div>

                        <div class="w-full">
                            S/ {{ $client_credito ?? 0 }} de {{ $client_linea_credito }} Soles
                        </div>
                    </div>
                </div>
                @else
                <div>No puede utilizar la Línea de Crédito porque supera el limite establecido</div>
                @endif
                @endif

                <div></div>

                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendedor Referente</div>
                
                <div class="w-full" wire:ignore>

                    
                    <div class='relative searchable-list-brand'>
                        <input type='text' class='data-list-brand peer block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ' id="product-brand" spellcheck="false"  placeholder="Buscar una marca" name="vendedor_id"></input>
                        <svg class="outline-none cursor-pointer fill-gray-400 absolute transition-all duration-200 h-full w-4 -rotate-90 right-2 top-[50%] -translate-y-[50%]"
                            viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M0 256l512 512L1024 256z"></path>
                        </svg>
                        <ul class='absolute option-list-brand overflow-y-scroll w-full min-h-[0px] flex flex-col top-12 
                            left-0 bg-white rounded-sm scale-0 opacity-0 
                            transition-all 
                            duration-200 origin-top-left'>
                        </ul>
                    </div>

                    <script>
                    // see how to use at the end of the script
                    const domParser = new DOMParser();
                    const dataListBrand = {
                        el:document.querySelector('.data-list-brand'),
                        listEl:document.querySelector('.option-list-brand'),
                        arrow:document.querySelector(".searchable-list-brand>svg"),
                        currentValue:null,
                        listOpened :false,
                        optionTemplate:
                        `
                        <li
                            class='data-option-brand select-none break-words inline-block text-sm text-gray-500 bg-gray-100 odd:bg-gray-200 hover:bg-gray-300 hover:text-gray-700 transition-all duration-200 font-bold p-3 cursor-pointer max-w-full '>
                                [[REPLACEMENT]]
                        </li>
                        `,
                        optionElements:[],
                        options:[], 
                        find(str){
                            for(let i = 0;i<dataListBrand.options.length;i++){
                                const option = dataListBrand.options[i];
                                if(!option.toLowerCase().includes(str.toLowerCase())){
                                    dataListBrand.optionElements[i].classList.remove('block');
                                    dataListBrand.optionElements[i].classList.add('hidden');
                                }else{
                                    dataListBrand.optionElements[i].classList.remove('hidden');
                                    dataListBrand.optionElements[i].classList.add('block');
                                }
                            }
                        },  
                        remove(value){
                            const foundIndex = dataListBrand.options.findIndex(v=>v===value);
                            if(foundIndex!==-1){
                                dataListBrand.listEl.removeChild(dataListBrand.optionElements[foundIndex])
                                dataListBrand.optionElements.splice(foundIndex,1);
                                dataListBrand.options.splice(value,1);
                            }
                        },
                        append(value){    
                            if(!value || typeof value === 'object' || typeof value === 'symbol' || typeof value ==='function') return;
                            value = value.toString().trim();
                            if(value.length === 0) return; 
                            if(dataListBrand.options.includes(value)) return;

                            const html = dataListBrand.optionTemplate.replace('[[REPLACEMENT]]',value);
                            const targetEle = domParser.parseFromString(html, "text/html").querySelector('li');
                            targetEle.innerHTML = targetEle.innerHTML.trim();
                            dataListBrand.listEl.appendChild(targetEle);
                            dataListBrand.optionElements.push(targetEle);  
                            dataListBrand.options.push(value);

                            if(!dataListBrand.currentValue) dataListBrand.setValue(value);
                  
                            targetEle.onmousedown = (e)=>{
                                dataListBrand.optionElements.forEach((el,index)=>{
                                    if(e.target===el){
                                        dataListBrand.setValue(dataListBrand.options[index]);
                                        dataListBrand.hideList();
                                        return;
                                    }
                                })
                            }
                        },  
                        setValue(value){
                            dataListBrand.el.value = value;
                            dataListBrand.currentValue = value;
                        },
                        showList(){
                            dataListBrand.listOpened = true;
                            dataListBrand.listEl.classList.add('opacity-100');
                            dataListBrand.listEl.classList.add('scale-100');
                            dataListBrand.arrow.classList.add("rotate-0");
                        },
                        hideList(){
                            dataListBrand.listOpened = false;
                            dataListBrand.listEl.classList.remove('opacity-100');
                            dataListBrand.listEl.classList.remove('scale-100');
                            dataListBrand.arrow.classList.remove("rotate-0");
                        },
                        init(){ 
                            dataListBrand.arrow.onclick = ()=>{
                                dataListBrand.listOpened ? dataListBrand.hideList(): dataListBrand.showList();
                            } 
                            dataListBrand.el.oninput = (e)=>{
                                dataListBrand.find(e.target.value);
                            }
                            dataListBrand.el.onclick= (el)=>{
                                dataListBrand.showList();
                                for(let el of dataListBrand.optionElements){
                                    el.classList.remove('hidden');
                                }
                            }
                            dataListBrand.el.onblur = (e)=>{
                                dataListBrand.hideList();
                                dataListBrand.setValue(dataListBrand.currentValue);
                            }
                        }
                    }

                    // how to use
                    dataListBrand.init(); 
                    // add items
                    const data = [
                        @foreach($users as $user) "{{ $user->name }}", @endforeach
                    ];
                    data.forEach(v=>(dataListBrand.append(v))); 
                    </script>
                </div>

                <div>Realizar el cobro de los productos antes de procesar el pago.</div>


                <div class="flex justify-between gap-8">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            S/ {{ $total }} Soles
                        </h2>
                    </div>
                    <div>
                        <button type="submit" id=="btn-procesar-pago" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Procesar Pago</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
