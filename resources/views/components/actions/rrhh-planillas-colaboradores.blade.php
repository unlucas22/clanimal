@if($item->status == 'pendiente') 
<div><a onclick='Livewire.emit("enviarPlanilla", {{ $item->id }})'>
    <x-btn-nuevo :content="'Enviar Planilla'"/></a></div>
@endif

@if($item->status != 'completado') 
<div><a onclick='Livewire.emit("openModal", "modal.store.user-for-spreadsheet", @json(["item_id" => $item->id]))'>
    <x-btn-edit/></a></div>
@endif