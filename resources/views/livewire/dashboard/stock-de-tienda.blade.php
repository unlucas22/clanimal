<x-slot name="title">Stock de Tienda</x-slot>

<div class="py-4">


    <div>
        <div class="p-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Stock de Tienda</h1>   
        </div>
        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter1" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter1" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchStore" placeholder="Buscar">
                        </div>
                    </div>
                </div>
                @if(\App\Models\Product::count())
                <div class="flex justify-end px-6">
                    <div class="flex justify-start">
                        <div><a wire:click='$emit("openModal", "modal.store.tienda")'>
                            <x-btn-nuevo/></a></div>
                    </div>
                </div>
                @endif

                
            </div>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>

                                @php($shifts_column = ['ID', 'Producto', 'ID De Producto', 'Cantidad', 'Registrado Por', 'Fecha de recepción'])

                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                                    @foreach($shifts_column as $key)
                                    <th scope="col" class="{{ $colStyle }}">
                                        {{ $key }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @php($td = 'p-4 text-base font-medium text-gray-900 dark:text-white')

                                @forelse($products as $product)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="{{ $td }}">
                                        {{ $product->id }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $product->products->name }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $product->products->id }}
                                    </td>
                                    <td class="{{ $td }}">
                                        {{ $product->stock }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $product->users->name }}
                                    </td>

                                    <td class="{{ $td }}">
                                        {{ $product->created_at->format('d/m/Y h:i A') }}
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="6" class="py-3 italic">No hay Historial</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>