<x-slot name="title">Finanzas</x-slot>

<div class="py-4">

    {{-- Ultimos ingresos --}}

    <div class="pt-4">
        <div class="mb-4 p-4">
            <div class="flex justify-between gap-8">
                <div></div>
                <div class="bg-white w-full  border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 p-6">
                    <div class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">En banco</div>
                    <div class="text-3xl mb-4">S/ {{ $en_banco_del_dia }}</div>
                    <div class="text-xl font-semibold text-gray-900 dark:text-white"></div>
                </div>

                <div class="w-full  bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 p-6">
                    <div class="text-xl  mb-4 font-semibold text-gray-900 dark:text-white">Ingresos</div>
                    <div class="text-3xl mb-4">S/ {{ $ingresos_del_dia }}</div>
                </div>

                <div class="bg-white w-full border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 p-6">
                    <div class="text-xl mb-4 font-semibold text-gray-900 dark:text-white">Salidas</div>
                    <div class="text-3xl mb-4">S/ {{ $salidas_del_dia }}</div>
                </div>
                <div></div>
            </div>
        </div>
    </div>

    <div>
        <div class="mb-4 p-4">
            <div class="flex justify-between">
                <div>
                    <div class="sm:pr-3">
                        <label for="searchfilter1" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter1" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="searchIngreso" placeholder="Buscar">
                        </div>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Últimos Ingresos y Salidas</h1>   
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

                                @php($shifts_column = ['ID', 'Tipo de operación', 'Origen o Destino', 'Monto', 'Fecha'])

                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                                    @foreach($shifts_column as $key)
                                    <th scope="col" class="{{ $colStyle }}">
                                        {{ $key }}
                                    </th>
                                    @endforeach
                                    <th scope="col" class="{{ $colStyle }}" style="max-width: 250px;">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-center">
                                @php($td = 'px-6 py-4')

                                @forelse($items as $item)
                                <tr >
                                    <td class="{{ $td }}">
                                        {{ $item->id }}
                                    </td>
                                </tr class="bg-white border-b">
                                @empty
                                <tr class="text-center py-3">
                                    <td colspan="{{ count($shifts_column)+1 }}" class="py-3 italic">No hay Ingresos/Salidas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>