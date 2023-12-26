<td class="{{ $td }}">
    {{ $item->users->name }}
</td>

<td class="{{ $td }}">
    {{ $item->users->roles->name }}
</td>

{{-- 
<td class="{{ $td }}">
    {{ $item->users->roles->sueldo }}
</td>
 --}}
<td class="{{ $td }}">
    {{ $item->dias_no_laborados }}
</td>

<td class="{{ $td }}">
    {{ $item->minutos_de_tardanzas }}
</td>

<td class="{{ $td }}">
    {{ $item->descuento }}
</td>

<td class="{{ $td }}">
    {{ $item->bonificacion }}
</td>

<td class="{{ $td }}">
    {{ $item->total }}
</td>

<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>