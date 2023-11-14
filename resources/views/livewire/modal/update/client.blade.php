<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Actualizar Cliente</h2>

    <form wire:submit.prevent="save" class="space-y-10 pt-8 ">
        
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

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Actualizar cliente
            </x-jet-button>
        </div>
    </form>
</div>