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

            <div class="space-y-2 p-4" id="form">

                <div class="flex justify-between">
                    <div class="font-bold">
                        Razón Social
                    </div>
                    <div>
                        {{ $warehouse_payment->warehouses->suppliers->name }}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        RUC
                    </div>
                    <div>
                        {{ $warehouse_payment->warehouses->suppliers->ruc }}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        {{ $warehouse_payment->warehouses->suppliers->banco }}
                    </div>
                    <div>
                        {{ $warehouse_payment->warehouses->suppliers->cuenta_bancaria }}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        TOTAL A PAGAR
                    </div>
                    <div>
                        {!! $warehouse_payment->warehouses->total_formatted !!}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        Pagado
                    </div>
                    <div>
                        S/ {{ $warehouse_payment->getMontoPagado() }} Soles
                    </div>
                </div>

               <div class="flex justify-between">
                    <div class="font-bold">
                        Restante
                    </div>
                    <div>
                        S/ {{ $warehouse_payment->getMontoRestante() }} Soles
                    </div>
                </div>


                <div class="pt-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $warehouse_payment->cuotas }} Cuotas
                    </h3>
                </div>
            </div>
            
            <div>
                <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
                        @foreach(['Cuota', 'Fecha', 'Estado', ''] as $index => $key)
                        <th scope="col" class="{{ $colStyle }}">
                            {{ $key }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                @php($td = 'p-2 text-center text-base font-medium text-gray-900 dark:text-white')

                @foreach($warehouse_payment->warehouse_fee_payments as $fee)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <td class="{{ $td }}">
                            S/ {{ $fee->cuota }} Soles
                        </td>

                        <td class="{{ $td }}">
                            {{ $fee->fecha }}
                        </td>
                        <td class="{{ $td }}">
                            {!! $fee->status_formatted !!}
                        </td>
                        <td class="{{ $td }} w-full">
                            @if($fee->status == 'en espera')
                            <a onclick="callPagarCuota({{ $fee->id }})"> <x-btn :content="'Pagar'" /></a>
                            @endif
                        </td>
                    </tr class="bg-white border-b">
                @endforeach
                </tbody>
            </table>
                
            </div>
        </div>
    </div>    
</div>