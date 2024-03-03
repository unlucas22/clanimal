<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Actualizar Control del trabajador
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 p-4">

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :name="'ip'" :model="'ip'" :label="'Dirección IPv4'" :required="'required'" />
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <x-form.input :type="'city'" :name="'city'" :model="'city'" :label="'Ciudad'" />
                    </div>
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <x-form.input :type="'device'" :name="'device'" :model="'device'" :label="'Dispositivo'" />
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <x-form.input :type="'hostname'" :name="'hostname'" :model="'hostname'" :label="'Empresa de Internet'" />
                </div>

                <div>
                    <x-form.select :name="'confirmed'" :model="'confirmed'" :label="'Acceso permitido'">
                        <option value="1">Confirmado</option>
                        <option value="0">Sin confirmar</option>
                    </x-form.select>
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