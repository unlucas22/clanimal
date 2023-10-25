<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Registrar Sede</h2>

    <form wire:submit.prevent="submit" class="space-y-10">

        <!-- name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Nombre') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- address -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address" value="{{ __('Dirección') }}" />
            <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model="address" autocomplete="address" />
            <x-jet-input-error for="address" class="mt-2" />
            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="phone" value="{{ __('Telefono') }}" />
            <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model="phone" autocomplete="phone" />
            <x-jet-input-error for="phone" class="mt-2" />
            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Correo -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Correo') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model="email" autocomplete="email" />
            <x-jet-input-error for="email" class="mt-2" />
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Registrar Sede
            </x-jet-button>
        </div>
    </form>
</div>