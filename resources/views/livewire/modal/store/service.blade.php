<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Registrar Servicio</h2>

    <form wire:submit.prevent="submit" class="space-y-10">

        <!-- name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Nombre') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- description -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="description" value="{{ __('Descripción') }}" />
            <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model="description" autocomplete="description" />
            <x-jet-input-error for="description" class="mt-2" />
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Registrar
            </x-jet-button>
        </div>
    </form>
</div>
