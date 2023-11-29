<x-app-layout>
<x-slot name="header">

    <div class="flex justify-between gap-8">
        <div class="flex justify-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Compras
            </h2>
        </div>
        <div class="flex justify-end">
            <button href="{{ route('dashboard.compras') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</button>
        </div>
    </div>

</x-slot>

<div class="pt-8 flex justify-end">
    <div class="bg-white shadow w-full rounded-lg max-w-7xl py-6 px-8 w-full">
        <div class="mt-6 flex justify-center">
            @livewire('dashboard.create.warehouse')
        </div>
    </div>
</div>
</x-app-layout>