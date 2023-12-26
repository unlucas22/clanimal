@if($item->status == 'completado' || $item->status == 'cancelado') 
<div><a onclick='Livewire.emit("openModal", "modal.update.user-for-spreadsheet", @json(["item_id" => $item->id]))'>
    <x-btn :content="'Ver'"/></a></div>
@else
<div><a onclick='Livewire.emit("openModal", "modal.update.user-for-spreadsheet", @json(["item_id" => $item->id, 'g' => true]))'>
    <x-btn :content="'Realizar Pago'"/></a></div>
@endif