<td class="{{ $td }}">
    {{ $item->suppliers->name }}
</td>
<td class="{{ $td }}">
    {{ $item->ruc ?? $item->suppliers->ruc }}
</td>