@if($item->status != 'listo para retiro' && $item->status != 'terminado' && $item->status != 'cancelado')
<div><a href="{{ route('dashboard.venta.atencion-veterinaria', ['hashid' => $item->hashid]) }}"><x-btn/></a></div>
@endif