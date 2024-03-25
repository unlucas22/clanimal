<x-app-layout>

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

                            @if($bill->enlace != null)
                            <div class="flex justify-start">
                                <a target="_blank" href="{{ $bill->enlace }}"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Boleta/Factura</button></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @foreach($bill->product_for_sales as $product)
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
                                        S/ {{ $bill->total }} Soles
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
                                        S/ {{ $product->product_details->precio_venta_con_igv }} Soles
                                    </td>
                                    <td class="px-6 py-4">
                                        S/ {{ $product->product_details->discount }} Soles
                                    </td>
                                    <td class="px-6 py-4">
                                        S/ {{ $product->product_details->precio_venta_con_igv - $product->product_details->precio_venta_sin_igv }} Soles
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</x-app-layout>