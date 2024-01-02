<td class="{{ $td }}">
    {{ $item->reported_at->format('d/m/Y h:i A') }}
</td>

<td class="{{ $td }}">
    @if($item->validated_at !== null)
    {{ $item->validated_at->format('d/m/Y h:i A') }}
    @endif
</td>

<td class="{{ $td }}">
    {{ $item->users->name }}
</td>

<td class="{{ $td }}">
    {{ $item->users->companies->name }}
</td>

<td class="{{ $td }}">
    {{ $item->total_tarjetas ?? 0 }}
</td>

<td class="{{ $td }}">
    {{ $item->total_efectivo ?? 0 }}
</td>

<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>