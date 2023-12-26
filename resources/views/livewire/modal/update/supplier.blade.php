<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Actualizar Proveedor
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 p-4" id="form">

               <!-- name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="ruc" value="{{ __('RUC') }}" />
                    <x-jet-input id="ruc" type="text" class="mt-1 block w-full" wire:model="ruc" autocomplete="ruc" />
                    <x-jet-input-error for="ruc" class="mt-2" />
                    @error('ruc') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="address" value="{{ __('Dirección') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model="address" autocomplete="address" />
                    <x-jet-input-error for="address" class="mt-2" />
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="phone" value="{{ __('Telefono') }}" />
                    <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model="phone" autocomplete="phone" />
                    <x-jet-input-error for="phone" class="mt-2" />
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="cuenta_bancaria" value="{{ __('Cuenta N°') }}" />
                    <x-jet-input id="cuenta_bancaria" type="text" class="mt-1 block w-full" wire:model="cuenta_bancaria" autocomplete="cuenta_bancaria" />
                    <x-jet-input-error for="cuenta_bancaria" class="mt-2" />
                    @error('cuenta_bancaria') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="beneficiario" value="{{ __('Beneficiario') }}" />
                    <x-jet-input id="beneficiario" type="text" class="mt-1 block w-full" wire:model="beneficiario" autocomplete="beneficiario" />
                    <x-jet-input-error for="beneficiario" class="mt-2" />
                    @error('beneficiario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="banco" value="{{ __('Banco') }}" />
                    <x-jet-input id="banco" type="text" class="mt-1 block w-full" wire:model="banco" autocomplete="banco" />
                    <x-jet-input-error for="banco" class="mt-2" />
                    @error('banco') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="moneda" value="{{ __('Moneda') }}" />
                    <x-jet-input id="moneda" type="text" class="mt-1 block w-full" wire:model="moneda" autocomplete="moneda" />
                    <x-jet-input-error for="moneda" class="mt-2" />
                    @error('moneda') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="items-center pt-2 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button id="submit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>