<div>
	<a wire:click='$emit("openModal", "modal.update.cuentas-por-cobrar", @json(["item_id" => $item->id]))'>
        <x-btn :content="'Cobrar'" />
    </a>
</div>