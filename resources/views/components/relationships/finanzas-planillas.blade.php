<td class="{{ $td }}">
    {{ $item->fecha->format('m - Y') }}
</td>

<td class="{{ $td }}">
    {{ count($item->user_for_spreadsheets) }}
</td>

<td class="{{ $td }}">
    {{ $item->total }}
</td>

<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>

<td class="{{ $td }}">
    @if($item->validated_at !== null)
    {{ $item->validated_at->format('H:i m/d') }}
    @endif
</td>