<x-app-layout>

<x-slot name="header">
    <div class="flex justify-end">
        <a href="{{ route('dashboard.clients') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
    </div>
</x-slot>

<x-basic-card>
    @livewire('dashboard.show.client', [ 'id' => $id ])
</x-basic-card>

<!-- NO ELIMINAR
    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Ocasional</span>

    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Básico</span>

    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">VIP</span>

    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-indigo-900 dark:text-indigo-300">Sin definir</span>
-->

</x-app-layout>