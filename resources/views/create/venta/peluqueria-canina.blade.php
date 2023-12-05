<x-app-layout>
<x-slot name="header">
    <div class="flex justify-end">
        <button onclick="javascript:history.go(-1)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</button>
    </div>
</x-slot>

<x-basic-card>
    @livewire('dashboard.create.venta.peluqueria-canina')
</x-basic-card>

</x-app-layout>