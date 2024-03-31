<td class="{{ $td }}">
    {{ $item->updated_at }}
</td>
<td class="{{ $td }}">
    {{ $item->name }}
</td>
<td class="{{ $td }}">
    S/ {{ $item->linea_credito }} Soles
</td>
<td class="{{ $td }}">
    S/ {{ $item->credito_actual }} Soles
</td>
<td class="{{ $td }}">
    @if($item->credito_actual != 0)
    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">En proceso</span>
    @else
    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completado</span>
    @endif
</td>