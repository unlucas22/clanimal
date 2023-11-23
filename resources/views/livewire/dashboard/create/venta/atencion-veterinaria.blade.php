<div class="flex justify-between">
    <div class="w-full">

        <div>
            <div>
                <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-gray-900 dark:text-white mt-2">Paciente {{ $pet_name }}</h2>
            </div>

            <div>
                <form wire:submit.prevent="agregarItem" class="space-y-10 max-w-md">
                    
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción de servicio</label>
                        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" wire:model.defer="description" required></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-form.select :label="'Medico Veterinario Tratante'" :name="'user_id'" :model="'user_id'">
                            <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }}</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-form.select>
                        @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-between">
                        <div>Costo de Servicio</div>
                        <div>
                            <x-form.input :type="'number'" :name="'price'" :model="'price'" :required="' required step=0.01 '" :label="''" />
                        </div>
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                        <x-jet-button>
                            Agregar
                        </x-jet-button>
                    </div>

                </form>
            </div>
        </div>
        
    </div>
    <div class="w-full">
        
        <div>
            <div>
                <h2 class="mb-4 text-lg tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-2">Servicios realizado</h2>
            </div>

            <div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-s-lg">
                                    Servicio
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Medico Tratante
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-e-lg">
                                    Costo
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-e-lg">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($presales as $presale)
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $presale->description }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $presale->users->name }}
                                </td>
                                <td class="px-6 py-4">
                                    ${{ $presale->price }}
                                </td>
                                <td class="px-6 py-4">
                                    <div><button wire:click="eliminarPresale({{ $presale->id }})" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 cursor-pointer" >Retirar</button></div>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center py-3">
                                <td colspan="4" class="py-3 italic">No hay Servicios Realizados</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold text-gray-900 dark:text-white">
                                <th scope="row" class="px-6 py-3 text-base">Total</th>
                                <td class="px-6 py-3">{{ count($presales) }} Servicios</td>
                                <td class="px-6 py-3"></td>
                                <td class="px-6 py-3">S/ {{ $total }} Soles</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

            <div class="pt-8">
                <div class="text-center mb-4 text-sm">El pago se realiza en Caja. ¿Desea comunicar a Caja el monto por cobrar?</div>

                <div class="flex justify-center gap-8">
                    <div>
                        <button onclick="callCancelButton()" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 disabled:opacity-25 transition">
                            Enviar a Caja
                        </button>
                    </div>
                </div>

                <script>
                    function callCancelButton() {
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "Una vez se comunica a caja el monto a cobrar el estado del turno cambiará a Listo para Retirar",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, {{ $pet_name }} listo para retirar'
                        }).then(function (res) {
                            if (res.isConfirmed) {
                                Livewire.emit('enviarCaja');
                            }
                        });
                    }
                </script>
            </div>

        </div>
    </div>
</div>
