<td class="{{ $td }}">
    {{ $item->roles->name }}
</td>
<td class="{{ $td }}">
    {{ $item->companies->name ?? '' }}
</td>
<td class="{{ $td }}">
    @if($item->active)
    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Activo</span>
    @else
    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Inactivo</span>
    @endif
</td>