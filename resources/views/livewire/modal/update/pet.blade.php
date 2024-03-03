<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Actualizar Mascota
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 p-4">

                @csrf

                <div class="relative z-0 w-full mb-6 group">
                    <x-form.input :name="'pet_name'" :model="'pet_name'" :label="'Nombre Mascota'" />
                    @error('pet_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <div class="relative z-0 w-full mb-6 group">

                        <x-form.select :name="'type_of_pet_id'" :model="'type_of_pet_id'" :label="'Especie'">
                            @forelse($type_of_pets as $type_of_pet)
                            <option @if($loop->first) selected @endif value="{{ $type_of_pet->id }}">{{ $type_of_pet->name }}</option>
                            @empty
                            <option>Error.</option>
                            @endforelse
                        </x-form.select>
                        @error('type_of_pet_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'pet_height'" :model="'pet_height'" :label="'Talla'" />
                        @error('pet_height') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'pet_age'" :model="'pet_age'" :label="'Edad'" />
                        @error('pet_age') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="relative z-0 w-full mb-6 group">

                        <x-form.select :name="'sex'" :model="'pet_sex'" :label="'Sexo'">
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </x-form.select>
                        </select>
                        @error('sex') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'pet_weight'" :model="'pet_weight'" :label="'Peso'" :type="'number'" />
                        @error('pet_weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        GUARDAR
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>