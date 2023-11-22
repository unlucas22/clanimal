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
    {!! $item->formatted_status !!}
</td>