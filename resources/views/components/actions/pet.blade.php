<div><a href="{{ route('dashboard.show.pet', ['hashid' => $item->hashid]) }}">
	<x-btn/></a></div>

<div><a onclick='Livewire.emit("openModal", "modal.update.pet", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>