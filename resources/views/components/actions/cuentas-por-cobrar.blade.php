<div>
	<a wire:click='$emit("openModal", "modal.update.cuentas-por-cobrar", @json(["item_id" => $item->id, "pagar" => false]))'>
        <x-btn :content="'Cobrar'" />
    </a>
</div>