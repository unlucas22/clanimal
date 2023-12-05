<x-app-layout>
<x-slot name="header">
    <div class="flex justify-end">
        <a href="{{ url('dashboard/sales') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
    </div>
</x-slot>

<x-basic-card>
    @livewire('dashboard.create.venta.productos')
</x-basic-card>

</x-app-layout>