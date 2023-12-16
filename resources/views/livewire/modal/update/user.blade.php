<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Actualizar Usuario
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-10 p-4" id="form">

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
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @empty
                        <option value="0">Error.</option>
                        @endforelse
                    </select>
                    @error('company_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- ROL -->
                <div class="form-group">
                    <label for="ss4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Estado Cuenta</label>
                    <select id="ss4" class="w-full form-control" wire:model.defer="active">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    @error('role_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- password -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                    <x-jet-input id="password" type="text" class="mt-1 block w-full" wire:model="password" autocomplete="password" />
                    <x-jet-input-error for="password" class="mt-2" />
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