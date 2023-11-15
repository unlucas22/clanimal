<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mascotas
    </h2>
</x-slot>

<div class="pt-8 flex justify-end">
    <div class="bg-white shadow rounded-lg max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8  mx-auto">
        <div class="mt-6 flex justify-center">
            @livewire('dashboard.create.pet')
        </div>
    </div>
</div>
</x-app-layout>