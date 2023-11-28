<x-app-layout>
<x-slot name="header">

    <div class="flex justify-between gap-8">
        <div class="flex justify-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Productos
            </h2>
        </div>

        <div>|</div>

        <div class="flex justify-between gap-4">
            <div>
               <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ Auth::user()->name }}
                </h2> 
            </div>
            <div>
                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Cajero</span>
            </div>
        </div>

        <div>|</div>

        <div class="flex justify-end">
            <a href="{{ url('dashboard/sales') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
        </div>
    </div>

</x-slot>

<div class="pt-8 flex justify-end">
    <div class="bg-white shadow rounded-lg max-w-7xl py-6 px-8 w-full">
        <div class="mt-6">
            @livewire('dashboard.create.venta.productos')
        </div>
    </div>
</div>
</x-app-layout>