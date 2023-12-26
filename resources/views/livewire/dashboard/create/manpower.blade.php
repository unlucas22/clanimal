<div class="pt-8">
    
    
    <div class="p-4">

        <div>
            <h1 class="mt-8 text-2xl font-semibold">Datos de colaborador</h1>
        </div>

        <div class="mt-6">
           <form class="space-y-8" wire:submit.prevent="submit">

                <div class="mb-4">
                    <label for="default-search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Agregar Texto" wire:model.defer="dni" name="dni" min="8" max="8" required>
                        <a class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click="search()" wire:loading.attr="disabled">
                        <span wire:loading.remove wire.target="search()">Buscar</span>
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

                <div class="w-full">
                    <x-form.input :name="'name'" :model="'user_name'" :label="'Datos'" :required="'disabled'" />
                    @error('user_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <label for="ssc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Puesto</label>
                        <select id="ssc" name="role_id" wire:model.defer="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @forelse($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @empty
                            <option value="0">Error. Sin puestos disponibles.</option>
                            @endforelse
                        </select>
                    </div>


                    <div>
                        <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de contratación</label>
                        <div class="relative max-w-sm">
                          <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                             <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                              </svg>
                          </div>
                          <input datepicker datepicker-format="mm/dd/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="datepicker" placeholder="Seleccionar Fecha" name="fecha" id="fecha" required value="{{ now()->format('m/d/Y') }}" onchange="handler(event);">
                        </div>
                    </div>
                </div>

                <script>
                    window.onload = function(){
                        const datepickerEl = document.getElementById('datepicker');
                        
                        new Datepicker(datepickerEl, {
                            // options
                        });
                    }
                </script>

                <div>
                    <label class="relative inline-flex items-center mb-5 cursor-pointer">
                        <input type="checkbox" wire:model="active" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</span>
                    </label>
                </div>

                <div>
                    <h1 class="mt-8 text-2xl font-semibold">Datos de contacto</h1>
                </div>

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <x-form.input :type="'email'" :name="'email'" :model="'user_email'" :label="'Correo electronico'" :required="'required'" />
                        @error('user_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="w-full">
                        <x-form.input :name="'phone'" :id="'phone'" :model="'user_phone'" :label="'Número de telefono'" />
                        @error('user_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        <span class="text-red-500 text-xs" id="error-message"></span>
                    </div>
                </div>

                <div>
                    <h1 class="mt-8 text-2xl font-semibold">Contactos de emergencia</h1>
                </div>

                <div class="flex justify-between gap-8">
                    <div class="w-full">
                        <x-form.input :name="'contact_name_emergency'" :model="'contact_name_emergency'" :label="'Nombre y Apellido'" />
                        @error('contact_name_emergency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-full">
                        <x-form.input :name="'contact_type_emergency'" :model="'contact_type_emergency'" :label="'Parentesco'" />
                        @error('contact_type_emergency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="w-full">
                        <x-form.input :name="'contact_phone_emergency'" :model="'contact_phone_emergency'" :label="'Número de telefono'" />
                        @error('contact_phone_emergency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>


                <script>
                    var telefonoRegex = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{3,}$/;

                    var inputTelefono = document.getElementById('phone');
                    var errorMessage = document.getElementById('error-message');
                    var submitBtn = document.getElementById('submit');

                    inputTelefono.addEventListener('input', function () {
                        validarTelefono();
                    });

                    function validarTelefono() {
                        var numeroTelefono = inputTelefono.value;

                        if (telefonoRegex.test(numeroTelefono)) {
                            errorMessage.textContent = '';
                            submitBtn.removeAttribute('disabled'); 
                        } else {
                            errorMessage.textContent = 'Número de teléfono no válido';
                            submitBtn.setAttribute('disabled', 'disabled');
                        }
                    }
                </script>

                <div>
                    <h1 class="mt-8 text-2xl font-semibold">Métodos de Pago</h1>
                </div>

                <div class="flex justify-between gap-8">
                    
                    <div class="w-full">
                        <x-form.input :name="'cuenta_bancaria'" :model="'cuenta_bancaria'" :label="'Cuenta bancaria'" />
                        @error('cuenta_bancaria') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @php($id = $id ?? uniqid())
                    <div class="w-full">
                        <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Entidad bancaria</label>
                        <select id="{{ $id }}" name="payment_method_id" wire:model.defer="payment_method_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @forelse($payment_methods as $payment_method)
                            <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                            @empty
                            <option value="0">Error. Sin metodos de pago disponibles.</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-center px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    <x-jet-button id="submit">
                        Guardar
                    </x-jet-button>
                </div>
           </form>
        </div>
    </div>
</div>