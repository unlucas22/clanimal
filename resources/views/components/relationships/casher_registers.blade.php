<td class="{{ $td }}">
    @if($item->closed_at !== null)
    {{ $item->closed_at->format('d/m/Y h:i A') }}
    @endif
</td>

<td class="{{ $td }}">
    @if($item->validated_at !== null)
    {{ $item->validated_at->format('d/m/Y h:i A') }}
    @endif
</td>

<td class="{{ $td }}">
    {{ $item->cashers->name }}
</td>

<td class="{{ $td }}">
    {{ $item->cashers->users->name }}
</td>

<td class="{{ $td }}">
    S/ {{ $item->total_tarjeta }} Soles
</td>

<td class="{{ $td }}">
    S/ {{ $item->total_virtual }} Soles
</td>

<td class="{{ $td }}">
    S/ {{ $item->total_efectivo }} Soles
</td>

<td class="{{ $td }}">
    S/ {{ $item->en_caja }} Soles
</td>

<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>