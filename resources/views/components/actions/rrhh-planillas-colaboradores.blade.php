@if($item->status == 'pendiente') 
<div><a onclick='Livewire.emit("openModal", "modal.store.user-for-spreadsheet", @json(["item_id" => $item->id]))'>
    <x-btn-edit/></a></div>
@endif