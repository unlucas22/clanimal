<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between gap-8">
        <div class="flex justify-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('dashboard.clients') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
        </div>
    </div>

</x-slot>

<div class="pt-8 flex justify-end ">
    <div class="bg-white shadow rounded-lg max-w-7xl py-6 px-8 w-full">
        <div class="mt-6 flex justify-center">
            {!! $factura !!}
        </div>
    </div>
</div>

</x-app-layout>