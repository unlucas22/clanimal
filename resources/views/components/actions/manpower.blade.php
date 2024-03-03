<div><a wire:click='$emit("openModal", "modal.update.manpower", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>

@if(count($item->users->histories))
<div><a wire:click='$emit("openModal", "modal.history", @json(["item_id" => $item->id]))'><x-btn :content="'Historial'"/></a></div>
@endif