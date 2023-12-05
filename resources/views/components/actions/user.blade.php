<div><a wire:click='$emit("openModal", "modal.update.user", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>

@if($item->histories_count)
<div><a wire:click='$emit("openModal", "modal.history", @json(["item_id" => $item->id]))'><x-btn :content="'Historial'"/></a></div>
@endif