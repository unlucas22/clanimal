<td class="{{ $td }}">
    {{ $item->users->name }}
</td>
<td class="{{ $td }}">
    {{ $item->confirmed ? 'Confirmado' : 'Sin confirmar' }}
</td>

<td class="{{ $td }}">
    {{ $item->reasons->name }}
</td>