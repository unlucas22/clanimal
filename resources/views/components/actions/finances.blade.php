<div>
	<a wire:click='$emit("openModal", "modal.update.finance", @json(["item_id" => $item->id]))'>
        <x-btn/>
    </a>
</div>