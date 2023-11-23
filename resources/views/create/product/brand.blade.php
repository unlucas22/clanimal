<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Marcas
    </h2>
</x-slot>

<div class="pt-8 flex justify-end">
    <div class="bg-white shadow rounded-lg max-w-7xl px-8 w-full">
        <div class="flex justify-center">
            @livewire('dashboard.product-brands')
        </div>
    </div>
</div>
</x-app-layout>