<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registrar Cliente
    </h2>
</x-slot>

<div class="py-0 sm:py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div>
            <h1 class="mt-8 text-4xl">Formulario</h1>
        </div>

        <h4 class="mt-6 text-gray-500">
            Este formulario se utiliza para ingresar y administrar datos relacionados con clientes y sus mascotas. Complete los campos requeridos con precisión y asegúrese de mantener la información actualizada para un seguimiento efectivo.
        </h4>

        <div class="mt-14">
           <form wire:submit.prevent="save">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'name'" :model="'name'" :label="'Nombre y apellido'" :required="'required'" />
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :type="'email'" :name="'email'" :model="'email'" :label="'Correo electronico'" :required="'required'" />
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'phone'" :model="'phone'" :label="'Número de telefono'" />
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'address'" :model="'address'" :label="'Dirección'" />
                    </div>
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

                <div class="flex items-center mb-4 pt-4">
                    <input id="default-checkbox" type="checkbox" wire:model="asign_pet" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Asignar Mascota</label>
                </div>

                @if($asign_pet)

                <div>
                    <h2 class="mt-8 text-2xl">Mascota</h2>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 pt-4">
                    <div class="relative z-0 w-full mb-6 group" style="margin-top:25px;">
                        <x-form.input :name="'pet_name'" :model="'pet_name'" :label="'Nombre de Pila'" />
                        @error('pet_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">

                        <x-form.select :name="'type_of_pet_id'" :model="'type_of_pet_id'" :label="'Tipo de Mascota'">
                            @forelse($type_of_pets as $type_of_pet)
                            <option @if($loop->first) selected @endif value="{{ $type_of_pet->id }}">{{ $type_of_pet->name }}</option>
                            @empty
                            <option>Error.</option>
                            @endforelse
                        </x-form.select>
                        @error('type_of_pet_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-4 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">

                        <x-form.select :name="'sex'" :model="'pet_sex'" :label="'Sexo'">
                            <option selected value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </x-form.select>
                        </select>
                        @error('sex') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group" style="margin-top:25px;">
                        <x-form.input :name="'pet_age'" :model="'pet_age'" :label="'Edad'" :type="'number'" />
                        @error('pet_age') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group" style="margin-top:25px;">
                        <x-form.input :name="'pet_height'" :model="'pet_height'" :label="'Talla'" :type="'number'" />
                        @error('pet_height') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group" style="margin-top:25px;">
                        <x-form.input :name="'pet_weight'" :model="'pet_weight'" :label="'Peso'" :type="'number'" />
                        @error('pet_weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div> 

                <div class="relative z-0 w-full mb-6 group">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observación</label>
                    <textarea wire:model="pet_description" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nota sobre la mascota..."></textarea>
                    @error('note') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                @endif

                <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <x-jet-button>
                        Registrar Cliente @if($asign_pet) Y su Mascota @endif
                    </x-jet-button>
                </div>
           </form>
        </div>
    </div>
</div>