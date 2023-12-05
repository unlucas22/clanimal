<div><a href="{{ route('dashboard.show.client', ['hashid' => $item->hashid]) }}"><x-btn/></a></div>

<div><a onclick='Livewire.emit("openModal", "modal.update.client", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>

<div><a href="{{ route('dashboard.create.shift', ['hashid' => $item->hashid]) }}"><x-btn :content="'Nueva Cita'"/></a></div>