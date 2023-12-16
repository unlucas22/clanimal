<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Reporte diario de Finanzas
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="submit" class="space-y-4 p-4">

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Deposito bancario
                    </h3>
                </div>

                <div>
                    <x-jet-label for="monto_efectivo" value="{{ __('Monto') }}" />
                    <x-jet-input id="monto_efectivo" type="number" class="mt-1 block w-full" wire:model.defer="monto_efectivo" oninput="sumarTotal()" autocomplete="monto_efectivo" />
                    <x-jet-input-error for="monto_efectivo" class="mt-2" />
                    @error('monto_efectivo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-jet-label for="numero_operacion" value="{{ __('Número de operación') }}" />
                    <x-jet-input id="numero_operacion" type="number" class="mt-1 block w-full" wire:model.defer="numero_operacion" autocomplete="numero_operacion"  required />
                    <x-jet-input-error for="numero_operacion" class="mt-2" />
                    @error('numero_operacion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                    <div class="relative w-full">
                      <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                         <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                          </svg>
                      </div>
                      <input datepicker datepicker-format="mm/dd/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="datepicker" placeholder="Seleccionar Fecha" name="fecha" id="fecha" required value="{{ now()->format('m/d/Y') }}" disabled onchange="handler(event);">
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        OpenPay / IziPay
                    </h3>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="monto_tarjetas" value="{{ __('Monto') }}" />
                    <x-jet-input id="monto_tarjetas" type="number" class="mt-1 block w-full" wire:model.defer="monto_tarjetas" oninput="sumarTotal()" autocomplete="monto_tarjetas" />
                    <x-jet-input-error for="monto_tarjetas" class="mt-2" />
                    @error('monto_tarjetas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>


                <div>
                    <x-jet-label for="monto_total" value="{{ __('Total') }}" />
                    <x-jet-input id="monto_total" type="number" class="mt-1 block w-full" autocomplete="monto_tarjetas" disabled />
                    <x-jet-input-error for="monto_tarjetas" class="mt-2" />
                </div>

                <div class="items-center pt-2 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Enviar reporte
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>