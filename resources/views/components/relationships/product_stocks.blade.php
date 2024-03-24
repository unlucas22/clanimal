<td class="{{ $td }}">
	{{ $item->name }}
</td>
<td class="{{ $td }}">
    {{ $item->product_in_warehouses_count }}
</td>
<td class="{{ $td }}">
	@php($stock = 0)
	@foreach($item->product_in_warehouses as $product_stock)
	@php($stock += $product_stock->product_stocks[0]->stock)
	@endforeach

    {{ $stock }}
</td>
<td class="{{ $td }}">
    {{ $item->product_in_warehouses[0]->warehouses->fecha_formatted }}
</td>
<td class="{{ $td }}">
	@foreach($item->product_in_warehouses as $warehouse)
		@if($warehouse->fecha_de_vencimiento != null)
		{{ $warehouse->fecha_de_vencimiento }}
		@break
		@endif
	@endforeach
</td>