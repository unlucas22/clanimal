<div class="flex justify-center pt-8">
    <form wire:submit.prevent="submit" class="space-y-10">
    <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-2">Registrar nueva mascota</h2>

        @csrf

        <div>
            <label for="default-search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Agregar Texto" wire:model.defer="dni" name="dni" min="8" max="8">
                <a class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer" wire:click="searchClient">Buscar</a>
            </div>
            @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

         <x-form.input :label="'Cliente'" :name="'client'" :model="'client'" :placeholder="'Buscar primero por DNI'" :required="'disabled'" />

        <div>

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
                        <option selected value="macho">Macho</option>
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

            
            <div class="relative z-0 w-full mb-6 group">
                <x-form.input :name="'pet_description'" :model="'pet_description'" :label="'Observación'" :placeholder="'Nota sobre la mascota...'" />
                @error('note') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
        <div class="p-4 flex justify-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Guardar</button>
        </div>

    </form>
</div>