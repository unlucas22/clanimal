<x-slot name="header">

    <div class="flex justify-between gap-8">
        <div class="flex justify-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar nuevo cliente
            </h2>
        </div>
        <div class="flex justify-end">
            <button onclick="javascript:history.go(-1)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</button>
        </div>
    </div>
</x-slot>

<div class="py-0 sm:py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div>
            <h1 class="mt-8 text-2xl">Datos del cliente</h1>
        </div>

        <div class="mt-6">
           <form wire:submit.prevent="save">
                

                <div class="flex justify-between gap-8">
                    <div class="w-full">

                        <div class="mb-4">
                            <label for="default-search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Agregar Texto" wire:model.defer="dni" name="dni" min="8" max="8" required>
                                <a class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click="searchClient()" wire:loading.attr="disabled">
                                <span wire:loading.remove wire.target="searchClient()">Buscar</span>
                                <span wire:loading>
                                    <button disabled type="button" class="inline-flex items-center">
                                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                        </svg>
                                        Buscando...
                                    </button>
                                </span>
                                </a>
                            </div>
                            @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative z-0 w-full mb-6 group">
                            <x-form.input :name="'name'" :model="'name'" :label="'Nombres'" :required="'required'" />
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="relative z-0 w-full mb-6 group">
                            <x-form.input :name="'last_name'" :model="'last_name'" :label="'Apellidos'" :required="'required'" />
                            @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative z-0 w-full mb-6 group">
                            <x-form.input :name="'address'" :model="'address'" :label="'Dirección'" />
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>                        
                    </div>
                    <div class="w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-form.input :type="'email'" :name="'email'" :model="'email'" :label="'Correo electronico'" :required="'required'" />
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="relative z-0 w-full mb-6 group">
                            <x-form.input :name="'phone'" :model="'phone'" :label="'Número de telefono'" />
                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- 
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
                 --}}

                <label class="relative inline-flex items-center mb-5 cursor-pointer">
                    <input type="checkbox" wire:model="asign_pet" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Asignar Mascota</span>
                </label>

                @if($asign_pet)

                <div class="flex justify-between mt-8">
                    <div><h2 class="text-2xl">Agregar Mascota</h2></div>
                    {{-- <div>
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">+ Agregar</button>
                    </div> --}}
                </div>

                <div class="flex justify-between pt-4 gap-4">
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'pet_name'" :model="'pet_name'" :label="'Nombre'" />
                        @error('pet_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
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
                        <x-form.input :name="'pet_height'" :model="'pet_height'" :label="'Talla'" />
                        @error('pet_height') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'pet_weight'" :model="'pet_weight'" :label="'Peso'" :type="'number'" />
                        @error('pet_weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'pet_description'" :model="'pet_description'" :label="'Observación'" :placeholder="'Nota sobre la mascota...'" />
                        @error('note') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                @endif

                <div class="flex items-center justify-center px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <x-jet-button>
                        Guardar
                    </x-jet-button>
                </div>
           </form>
        </div>
    </div>
</div>