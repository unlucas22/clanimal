<div><a href="{{ route('dashboard.show.pet', ['hashid' => $item->hashid]) }}" type="button" class="inline-block px-2 py-1.5 text-white font-medium text-xs leading-tight uppercase rounded shadow-md bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out cursor-pointer" >Abrir</a></div>

<div><a onclick='Livewire.emit("openModal", "modal.update.pet", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>