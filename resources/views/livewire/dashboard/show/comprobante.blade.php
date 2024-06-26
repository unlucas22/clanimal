<div class="flex justify-end ">
    <div class="bg-white shadow rounded-lg max-w-7xl py-6 w-full">
        
        <div class="bg-white block sm:flex items-center justify-between lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700  px-2">
            <div class="flex justify-between w-full mb-1">
                
                <div class="mb-4">
                    <h1 class="text-xl mt-3 font-semibold text-gray-900 sm:text-2xl dark:text-white">Comprobante</h1>
                </div>

                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex justify-end">
                        <div class="flex justify-between gap-8">
                            <div class="flex justify-start">
                                <div>
                                    <a href="{{ route('dashboard.sales') }}" type="button" class="text-white bg-[#24292F] hover:bg-[#24292F]/90 focus:ring-4 focus:outline-none focus:ring-[#24292F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 font-semibold">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2">
                                          <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                        </svg>

                                        RETORNO
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->has('nubefact'))
                <div class="text-center text-red-500 font-semibold pb-4">
                    <h4>{{ $errors->first('nubefact') }}</h4>
                </div>
            @endif
        </div>

        <script>
            function cancelarOrden(item_id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Una vez que cancelas la orden no podrás recuperar su información",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, cancelar'
                }).then(function (res) {
                    if (res.isConfirmed) {

                        Livewire.emit('cancelarOrden');
                        Livewire.emit('refreshComponent');
                    }
                });
            }

            function procesarPago(item_id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Una vez que procesas el pago no podrás cancelarlo",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, procesar pago'
                }).then(function (res) {
                    if (res.isConfirmed) {
                        Livewire.emit('procesarPago');

                        Livewire.emit('refreshComponent');
                    }
                });
            }
        </script>

        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('abrirEnlace', (url) => {
                    window.open(url, '_blank');
                });
            });
        </script>

        <div class="bg-white block sm:flex items-center justify-between lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 px-2">
            <div class="flex justify-between w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl mt-3 font-semibold text-gray-900 sm:text-2xl dark:text-white">Datos</h1>
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
                                    <th scope="col" class="px-6 py-3">
                                        Cliente
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Metodo de Pago
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Fecha de emisión
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cajero
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Estado
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $bill->clients->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $bill->metodo_de_pago_formatted }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $bill->created_at->format('d/m/Y h:i A') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $bill->users->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {!! $bill->status_formatted !!}
                                    </td>
                                    <td class="px-6 py-4">
                                        S/ {{ $bill->total }} Soles
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(count($bill->product_for_sales))
        <div class="bg-white block sm:flex items-center justify-between lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700  px-2">
            <div class="flex justify-between w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl mt-3 font-semibold text-gray-900 sm:text-2xl dark:text-white">Productos</h1>
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
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Unidad de Medida
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Valor de unidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Descuento
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        IGV Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @foreach($bill->product_for_sales as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $product->cantidad }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $product->product_details->product_presentations->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->product_details->products->name }}
                                    </td>
                                    <td class="px-6 py-4">

                                        S/ {{ $product->product_details->getPrecioDeOferta() ?? $product->product_details->precio_venta_con_igv }} Soles
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->product_details->getPrecioDeOferta() != null)
                                        S/ 0 Soles
                                        @else
                                        S/ {{ $product->product_details->discount }} Soles
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->product_details->getPrecioDeOferta() != null)
                                        S/ 0 Soles
                                        @else
                                        S/ {{ $product->product_details->precio_venta_con_igv - $product->product_details->precio_venta_sin_igv }} Soles
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(count($bill->pack_for_sales))
        <div class="bg-white block sm:flex items-center justify-between lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700  px-2">
            <div class="flex justify-between w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl mt-3 font-semibold text-gray-900 sm:text-2xl dark:text-white">Ofertas</h1>
                </div>
            </div>
        </div>

        <div class="flex flex-col" style="padding-bottom: 60px;">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Cantidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Valor de unidad
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @foreach($bill->pack_for_sales as $pack)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $pack->packs->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @forelse($pack->packs->product_for_packs as $oferta)
                                            {{ $oferta->products->name }}.
                                        @empty
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $pack->cantidad }}
                                    </td>
                                    <td class="px-6 py-4">
                                        S/ {{ $pack->packs->precio }} Soles
                                    </td>
                                    <td class="px-6 py-4">
                                        S/ {{ $pack->packs->precio * $pack->cantidad }} Soles
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="fixed max-w-7xl right-0 left-0 bottom-0">
            <div class="bg-gray-100 w-full p-2 flex justify-center">
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex justify-center">
                        <div class="flex justify-center gap-8">
                            @if($bill->status == 'en proceso')
                            <div class="text-xl px-7 py-4 font-medium">
                                Total: <span class="font-semibold">S/ {{ $bill->total }} Soles</span>
                            </div>
                            <div>
                                <a onclick="procesarPago()">
                                    <button class="inline-flex items-center text-base px-7 py-4  font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                        </svg>

                                        Procesar Pago
                                    </button>
                                </a>
                            </div>
                            <div>
                                <button onclick="cancelarOrden()" type="button" id="deleteProductButton" class="inline-flex items-center text-base px-7 py-4 font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Cancelar
                                </button>
                            </div>
                            @endif

                            @if($bill->enlace != null)
                            <div class="flex justify-start">
                                <a target="_blank" href="{{ $bill->enlace }}"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-7 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Boleta/Factura</button></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>