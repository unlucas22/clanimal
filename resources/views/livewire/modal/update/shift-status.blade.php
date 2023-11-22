<div class="p-6">
    
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Actualizar Estado del turno</h2>

    <div class="py-10">
        <label for="abcd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccionar Estado</label>
        <select id="abcd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:change="$emit('statusSelected', $event.target.value)">
            @forelse($status_lista_de_espera as $option)
            <option @if($option == $status_id) selected @endif value="{{ $option }}">{{ ucwords($option) }}</option>
            @empty
            <option value="0">Sin seleccionar</option>
            @endforelse            
        </select>
    </div>

</div>
