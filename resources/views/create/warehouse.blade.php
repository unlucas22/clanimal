<x-app-layout>
<x-slot name="header">
    <div class="flex justify-end">
        <a href="{{ route('dashboard.compras') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
    </div>
</x-slot>

<x-basic-card>
    @livewire('dashboard.create.warehouse')
</x-basic-card>

</x-app-layout>