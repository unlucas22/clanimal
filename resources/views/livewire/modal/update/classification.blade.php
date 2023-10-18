<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Actualizar Clasificación</h2>

    <form wire:submit.prevent="submit" class="space-y-10">

        <!-- key -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="key" value="{{ __('Nombre') }}" />
            <x-jet-input id="key" type="text" class="mt-1 block w-full" wire:model="key" autocomplete="key" />
            <x-jet-input-error for="key" class="mt-2" />
            @error('key') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Titulo especial') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Actualizar
            </x-jet-button>
        </div>
    </form>
</div>
