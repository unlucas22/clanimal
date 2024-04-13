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

            <form wire:submit.prevent="save" class="space-y-4 p-4" id="form">

                <div>
                    <label class="relative inline-flex items-center mb-5 cursor-pointer">
                        <input type="checkbox" wire:model="factura" name="active" value="true" checked class="sr-only peer">
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

                    <div class="flex justify-center gap-2">
                        
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

                @if($radio == 'tarjeta')
                    <x-form.input :label="'Tarjeta'" :name="'client_tarjeta'" :model="'client_tarjeta'" :placeholder="''" :required="'required'" />
                @endif

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