<x-app-layout>

<x-slot name="header">
    <div class="flex justify-end">
        <a onclick="javascript:history.go(-1)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">Regresar</a>
    </div>
</x-slot>

<x-basic-card>
    @livewire('dashboard.show.caja')
</x-basic-card>

</x-app-layout>