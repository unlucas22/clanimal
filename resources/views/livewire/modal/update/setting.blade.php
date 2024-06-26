<div>
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Actualizar Configuración
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 p-4" id="form">

                <div class="col-span-6 sm:col-span-4">
                @if($setting->type != 'image')
                    <x-jet-label for="value" value="{{ __('Valor') }}" />
                    <x-jet-input id="value" type="text" class="mt-1 block w-full" wire:model="setting.value" autocomplete="value" />
                    <x-jet-input-error for="value" class="mt-2" />
                    @error('setting.value') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @else
                    <input type="file" wire:model="file">
                    @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @endif
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Descripción') }}" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model="setting.description" />
                    <x-jet-input-error for="address" class="mt-2" />
                    @error('setting.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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