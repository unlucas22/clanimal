<td class="{{ $td }}">
    {{ $item->fecha_formatted }}
</td>
<td class="{{ $td }}">
    {{ $item->suppliers->name }}
</td>
<td class="{{ $td }}">
    {{ $item->suppliers->ruc }}
</td>
<td class="{{ $td }}">
    {{ $item->value_type }}
</td>
<td class="{{ $td }}">
    {!! $item->total_formatted !!}
</td>
<td class="{{ $td }}">
    {!! $item->status_formatted !!}
</td>