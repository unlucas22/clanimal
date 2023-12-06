<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Registrar Usuario
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="submit" class="space-y-4 p-4">

                <!-- name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- DNI -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="dni" value="{{ __('DNI') }}" />
                    <x-jet-input id="dni" type="text" class="mt-1 block w-full"  name="dni" wire:model="dni" required autofocus autocomplete="dni" />
                    <x-jet-input-error for="name" class="mt-2" />
                    @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Correo -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="email" value="{{ __('Correo') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model="email" autocomplete="email" />
                    <x-jet-input-error for="email" class="mt-2" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                    <x-jet-input id="password" type="text" class="mt-1 block w-full" wire:model="password" autocomplete="password" />
                    <x-jet-input-error for="password" class="mt-2" />
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- ROL -->
                <div>
                    <label for="ss45" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                    <select id="ss45" name="role_id" wire:model.defer="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @forelse($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @empty
                        <option value="0">Error.</option>
                        @endforelse
                    </select>
                    @error('role_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Sede -->

                <div>
                    <label for="ss433" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sede</label>
                    <select id="ss433" name="company_id" wire:model.defer="company_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @forelse($sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->name }}</option>
                        @empty
                        <option value="0">Error.</option>
                        @endforelse
                    </select>
                    @error('company_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>