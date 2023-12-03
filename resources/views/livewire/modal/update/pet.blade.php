<div class="p-6">
    <form {{-- method="POST" action="{{ route('dashboard.store.pet') }}" --}} wire:submit.prevent="save" class="space-y-10 max-w-md">
    <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-2">Actualizar mascota</h2>

        @csrf
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
            
        <div class="p-4 flex justify-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Guardar</button>
        </div>

    </form>
</div>