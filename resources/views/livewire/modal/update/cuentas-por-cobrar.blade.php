<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Detalles
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="space-y-4 p-4">

                <div class="flex justify-between">
                    <div class="font-bold">Cliente</div>
                    <div>{{ $client->name }}</div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">DNI</div>
                    <div>{{ $client->dni }}</div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">Linea de Crédito</div>
                    <div>S/ {{ $client->linea_credito }} Soles</div>
                </div>

                <div class="flex justify-between text-red-500">
                    <div class="font-bold">Deuda</div>
                    <div>S/ {{ $client->credito_actual }} Soles</div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Compras realizadas
                    </h3>
                </div>
                
            </div>
            <div>
                <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                            @foreach(['Comprobante N°', 'Monto', 'Fecha'] as $index => $key)
                            <th scope="col" class="{{ $colStyle }}">
                                {{ $key }}
                            </th>
                            @endforeach
                            <th scope="col" class="{{ $colStyle }} text-center">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    @php($td = 'p-4 text-center text-base font-medium text-gray-900 dark:text-white')

                    @forelse($client->bills as $item)
                    @if($item->metodo_de_pago == 'credito')
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <td class="{{ $td }}">
                            {{ $item->id }}
                        </td>

                        <td class="{{ $td }}">
                            S/ {{ $item->total }} Soles
                        </td>

                        <td class="{{ $td }}">
                            {{ $item->created_at->format('d/m/Y') }}
                        </td>
                        <td class="p-4 space-x-2 flex justify-center">
                            <div class="flex justify-between gap-2" style="max-width: 250px;">
                            <a target="_blank" href="{{ route('dashboard.show.venta.factura', ['bill_id' => $item->id]) }}"><x-btn /></a>
                            </div>
                        </td>
                    </tr class="bg-white border-b">
                    @endif
                    @empty
                    <tr class="text-center py-3">
                        <td colspan="4" class="py-3 italic">No hay Compras</td>
                    </tr>
                    @endforelse    
                    </tbody>
                </table>
            </div>

            <div class="p-4 pt-6">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Pagos realizados
                        </h3>
                    </div>
                    @if($client->credito_actual != 0)
                    <div>
                        <a wire:click='$emit("openModal", "modal.store.client-payments", @json(["client_id" => $client->id]))'><x-btn-nuevo :content="'Pagar'" /></a>
                    </div>
                    @endif
                </div>
            </div>
            
            <div>
                <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                            @foreach(['N°', 'Cuota', 'Fecha'] as $index => $key)
                            <th scope="col" class="{{ $colStyle }}">
                                {{ $key }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    @php($td = 'p-4 text-center text-base font-medium text-gray-900 dark:text-white')

                    @forelse($client->client_payments as $client_payment)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <td class="{{ $td }}">
                            {{ $client_payment->id }}
                        </td>

                        <td class="{{ $td }}">
                            S/ {{ $client_payment->cuota }} Soles
                        </td>

                        <td class="{{ $td }}">
                            {{ $client_payment->created_at->format('d/m/Y') }}
                        </td>
                    </tr class="bg-white border-b">
                    @empty
                    <tr class="text-center py-3">
                        <td colspan="3" class="py-3 italic">Sin Pagos realizado</td>
                    </tr>
                    @endforelse    
                    </tbody>
                </table>
            </div>

        </div>
    </div>    
</div>