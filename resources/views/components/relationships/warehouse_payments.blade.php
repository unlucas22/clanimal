<td class="{{ $td }}">
    {{ $item->created_at->format('d/m/Y') }}
</td>
<td class="{{ $td }}">
    {{ $item->warehouses->value_type }}
</td>
<td class="{{ $td }}">
    {{ $item->warehouses->suppliers->name }}
</td>
<td class="{{ $td }}">
    {!! $item->warehouses->total_formatted !!}
</td>
<td class="{{ $td }}">
    S/ {{ $item->getMontoPagado() }} Soles
</td>
<td class="{{ $td }}">
    S/ {{ $item->getMontoRestante() }} Soles
</td>
<td class="{{ $td }}">
    {{ $item->cuotas }} cuotas
</td>
<td class="{{ $td }}">
    {{ $item->getCuotasPagadas() }}
</td> 
<td class="{{ $td }}">
    @if($item->getCuotasPagadas() == $item->cuotas)
        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>
    @else
        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">En proceso</span>
    @endif
</td>
