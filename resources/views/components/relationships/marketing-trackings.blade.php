<td class="{{ $td }}">
    {{ $item->marketing_campaigns->name }}
</td>

<td class="{{ $td }}">
    {{ $item->users->name }}
</td>

<td class="{{ $td }}">
    {{ $item->users->email }}
</td>

<td class="{{ $td }}">
    {{ $item->marketing_campaigns->fecha->format('Y-m-d') }}
</td>