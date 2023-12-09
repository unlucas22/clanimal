@if($item->status == 'en proceso')
<div>
    <button onclick='Livewire.emit("openModal", "modal.update.transfer", @json(["item_id" => $item->id]))' type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
        Cancelar
    </button>
</div>
@endif

<div><a href="{{ route('dashboard.show.transfer', ['hashid' => $item->hashid]) }}">
    <x-btn/></a></div>