<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Actualizar Control del cliente</h2>

    <form wire:submit.prevent="save" class="space-y-10 pt-8 ">
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

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Actualizar
            </x-jet-button>
        </div>
    </form>
</div>