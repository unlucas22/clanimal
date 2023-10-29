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
    {{ $item->shifts->appointment ?? 'Sin turno' }}
</td>