<div><a href="{{ route('dashboard.show.spreadsheet', ['hashid' => $item->hashid]) }}">
	<x-btn-edit :content="'Ver'" /></a></div>

@if($item->status == 'validacion')
<div><a wire:click="marcarComoCompletado({{ $item->id }})">
	<x-btn :content="'Marcar como Completado'" /></a></div>
@endif