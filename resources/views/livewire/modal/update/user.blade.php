<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Actualizar Usuario</h2>

    <form wire:submit.prevent="submit" class="space-y-10">

        <!-- name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Nombre') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Correo -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Correo') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model="email" autocomplete="email" />
            <x-jet-input-error for="email" class="mt-2" />
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- ROL -->
        <div class="form-group">
            <label for="ss1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Rol</label>
            <select id="ss1" class="w-full form-control" wire:model.defer="role_id">
                @forelse($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @empty
                <option value="0">Error.</option>
                @endforelse
            </select>
            @error('role_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- SEDE -->
        <div class="form-group">
            <label for="ss2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Sede</label>
            <select id="ss2" class="w-full form-control" wire:model.defer="company_id">
                @forelse($companies as $company)
                <option value="{{ $company->id }}">{{ $role->name }}</option>
                @empty
                <option value="0">Error.</option>
                @endforelse
            </select>
            @error('company_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Actualizar usuario
            </x-jet-button>
        </div>
    </form>
</div>
