<td class="{{ $td }}">
    {{ $item->ruc ?? $item->suppliers->name }}
</td>
<td class="{{ $td }}">
    {{ $item->product_in_warehouses_count }}
</td>