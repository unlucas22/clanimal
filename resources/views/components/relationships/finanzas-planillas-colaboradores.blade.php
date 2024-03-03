<td class="{{ $td }}">
    {{ $item->users->name }}
</td>

<td class="{{ $td }}">
    {{ $item->users->roles->name }}
</td>

<td class="{{ $td }}">
    S/ {{ $item->users->roles->sueldo }} Soles
</td>

<td class="{{ $td }}">
    {{ $item->dias_no_laborados }}
</td>

<td class="{{ $td }}">
    {{ $item->minutos_de_tardanzas }}
</td>

<td class="{{ $td }}">
    @if($item->descuento != null)
    S/ {{ $item->descuento }} Soles
    @endif
</td>

<td class="{{ $td }}">
    @if($item->bonificacion != null)
    S/ {{ $item->bonificacion }} Soles
    @endif
</td>

<td class="{{ $td }}">
    S/ {{ $item->total }} Soles
</td>

<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>