@php($id = $id ?? uniqid())
<div>
	<div>
        <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por Nombre</label>
        <input type="{{ $type ?? 'text' }}" name="name" id="{{ $id }}" wire:model.longest="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
    </div>
</div>

<div>
    <a wire:click='$emit("openModal", "modal.store.control")'>
        <x-jet-button>
            Crear nuevo
        </x-jet-button>
    </a>
</div>