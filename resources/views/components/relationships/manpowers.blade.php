<td class="{{ $td }}">
    {{ $item->users->name }}
</td>
<td class="{{ $td }}">
    {{ $item->users->cedula }}
</td>
<td class="{{ $td }}">
    {{ $item->users->address }}
</td>
<td class="{{ $td }}">
    {{ $item->users->email }}
</td>
<td class="{{ $td }}">
    {{ $item->users->phone }}
</td>
<td class="{{ $td }}">
    {{ $item->users->roles->name }}
</td>
<td class="{{ $td }}">
    {{ $item->fecha_de_contratacion->format('Y-m-d') }}
</td>
<td class="{{ $td }}">
    {{ $item->users->roles->sueldo }}
</td>
