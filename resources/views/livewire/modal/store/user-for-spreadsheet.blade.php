<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Modificar Planilla
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="submit" class="space-y-4 p-4">

                <div class="flex justify-between gap-8">
                    <div class="font-bold">
                        Beneficiario
                    </div>
                    <div>
                        {{ $item->users->name }}
                    </div>
                </div>

                <div class="flex justify-between gap-8">
                    <div class="font-bold">
                        Cargo
                    </div>
                    <div>
                        {{ $item->users->roles->name }}
                    </div>
                </div>

                <div class="flex justify-between gap-8">
                    <div class="font-bold">
                        Sueldo
                    </div>
                    <div>
                        S/ {{ $item->users->roles->sueldo }} Soles
                    </div>
                </div>

                <input type="hidden" name="sueldo" id="sueldo" value="{{ $item->users->roles->sueldo }}">

                <x-hr :content="'Descuentos'" />

                <div>
                    <x-jet-label for="aportes" value="{{ __('Aportes al Sistema de Pensiones') }}" />
                    <x-jet-input id="aportes" type="number" class="mt-1 block w-full" wire:model="aportes" autocomplete="aportes" />
                    <x-jet-input-error for="aportes" class="mt-2" />
                    @error('aportes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-between gap-8">
                    <div>
                        <x-jet-label for="dias_no_laborados" value="{{ __('Cantidad de días no laborados') }}" />
                        <x-jet-input id="dias_no_laborados" type="number" class="mt-1 block w-full" wire:model="dias_no_laborados" oninput="setMontoDias(this.value)" />
                        <x-jet-input-error for="aportes" class="mt-2" />
                        @error('dias_no_laborados') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-jet-label for="monto_dias_no_laborados" value="{{ __('Monto') }}" />
                        <x-jet-input id="monto_dias_no_laborados" type="number" class="mt-1 block w-full" disabled />
                        <x-jet-input-error for="monto_dias_no_laborados" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-between gap-8">
                    <div>
                        <x-jet-label for="minutos_de_tardanzas" value="{{ __('Minutos de retraso') }}" />
                        <x-jet-input id="minutos_de_tardanzas" type="number" class="mt-1 block w-full" wire:model="minutos_de_tardanzas" oninput="setMontoMinutos(this.value)" />
                        <x-jet-input-error for="aportes" class="mt-2" />
                        @error('minutos_de_tardanzas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-jet-label for="monto_minutos_de_tardanzas" value="{{ __('Monto') }}" />
                        <x-jet-input id="monto_minutos_de_tardanzas" type="number" class="mt-1 block w-full" disabled />
                        <x-jet-input-error for="monto_minutos_de_tardanzas" class="mt-2" />
                    </div>
                </div>

                <x-hr :content="'Bonificaciones'" />

                <div>
                    <x-jet-label for="monto_bonificacion" value="{{ __('Monto de bonificación') }}" />
                    <x-jet-input id="monto_bonificacion" type="number" class="mt-1 block w-full" wire:model="monto_bonificacion" />
                    <x-jet-input-error for="aportes" class="mt-2" />
                    @error('monto_bonificacion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="observation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                    <textarea id="observation" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" wire:model.defer="observation"></textarea>
                </div>

                <div class="items-center pt-2 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>