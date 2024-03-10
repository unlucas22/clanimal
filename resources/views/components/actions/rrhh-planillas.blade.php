<div><a href="{{ route('dashboard.show.rrhh-spreadsheet', ['hashid' => $item->hashid]) }}"><x-btn/></a></div>
@if($item->status == 'pendiente') 
<div><a onclick='Livewire.emit("enviarPlanilla", {{ $item->id }})'>
    <x-btn-nuevo :content="'Enviar Planilla'"/></a></div>
@endif