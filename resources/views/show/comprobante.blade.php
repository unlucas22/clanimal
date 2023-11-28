<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between gap-8">
        <div class="flex justify-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ventas
            </h2>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('dashboard.sales') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
        </div>
    </div>

</x-slot>

<div class="pt-8 flex justify-end ">
    <div class="bg-white shadow rounded-lg max-w-7xl py-6 px-8 w-full">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl">Comprobante de Pago</h2>
            </div>
            <div>
                <a target="_blank" href="{{ $bill->enlace }}"><button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Ver Boleta/Factura</button></a>
            </div>
        </div>

        <div class="pt-4 text-center">
            <h2 class="font-semibold text-xl">Datos</h2>
        </div>

        <div class="mt-6 flex justify-center">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $bill->clients->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $bill->metodo_de_pago_formatted }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->users->name }}
                            </td>
                            <td class="px-6 py-4">
                                ${{ $bill->total }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pt-8">
            <h2 class="font-semibold text-center text-xl">Productos</h2>
        </div>
        
        <div class="pt-4 flex justify-center">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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

                            <th scope="col" class="px-6 py-3">
                                Importe de Venta
                            </th>
                        </tr>
                    </thead>
                    <tbody>
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
                                {{ $product->product_details->amount }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->product_details->discount }}
                            </td>
                            <td class="px-6 py-4">
                                ${{ $product->product_details->precio_venta_con_igv - $product->product_details->precio_venta_sin_igv }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->product_details->amount }}
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
</div>

</x-app-layout>