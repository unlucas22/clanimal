<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Actualizar Proveedor</h2>

    <form wire:submit.prevent="submit" class="space-y-10">

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

        <div class="flex items-center justify-center px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Actualizar
            </x-jet-button>
        </div>
    </form>
</div>
