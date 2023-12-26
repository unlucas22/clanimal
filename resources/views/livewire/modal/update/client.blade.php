<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Actualizar Cliente
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 p-4">

                <div class="relative z-0 w-full group">
                    <x-form.input :name="'name'" :model="'name'" :label="'Nombre y apellido'" :required="'required'" />
                </div>

                <div class="relative z-0 w-full group">
                    <x-form.input :type="'email'" :name="'email'" :model="'email'" :label="'Correo electronico'" :required="'required'" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <x-form.input :name="'phone'" :model="'phone'" :label="'Número de telefono'" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <x-form.input :name="'address'" :model="'address'" :label="'Dirección'" />
                </div>
                
                @if(Auth::user()->isAdmin())
                <div>
                    <x-form.select :name="'status_id'" :model="'status_id'" :label="'Clasificación'">
                        @forelse($status as $key)
                        <option @if($loop->first) selected @endif value="{{ $key }}">{{ ucwords($key) }}</option>
                        @empty
                        <option>Error.</option>
                        @endforelse
                    </x-form.select>

                    @error('status_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif

                <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>