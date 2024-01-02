<td class="{{ $td }}">
    {{ $item->users->name }}
</td>
<td class="{{ $td }}">
    {{ $item->pets->name }}
</td>
<td class="{{ $td }}">
    {{ $item->pets->clients->name }}
</td>
<td class="{{ $td }}">
    {{ $item->services->name }}
</td>
<td class="{{ $td }}">
    @if($item->shifts->appointment != null)
    {{ $item->shifts->appointment->format('d/m/Y h:i A') }}
    @else
    Sin turno
    @endif
</td>