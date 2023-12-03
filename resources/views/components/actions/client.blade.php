<div><a href="{{ route('dashboard.show.client', ['hashid' => $item->hashid]) }}" type="button" class="inline-block py-3 px-2 text-white font-medium text-xs leading-tight uppercase rounded shadow-md bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out cursor-pointer" >Abrir</a></div>

<div><a onclick='Livewire.emit("openModal", "modal.update.client", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>

<div><a href="{{ route('dashboard.create.shift', ['hashid' => $item->hashid]) }}" type="button" class="inline-block py-3 px-2 text-white font-medium text-xs leading-tight uppercase rounded shadow-md bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out cursor-pointer" >Nueva Cita</a></div>