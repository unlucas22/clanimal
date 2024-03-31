<div>
    <a wire:click='$emit("openModal", "modal.update.ingreso", @json(["item_id" => $item->id]))'>
        <x-btn-nuevo :content="'Cambiar Estado'"/></a>
</div>