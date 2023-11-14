{{-- 
<td class="{{ $td }}">
    {{ $item->pets_count }}
</td>
<td class="{{ $td }}">
    {{ $item->sales }}
</td> --}}
<td class="{{ $td }}">
    {!! $item->reports->formatted_status !!}
</td>
{{-- añadir link al seguimiento 
<td class="{{ $td }}">
    {{ $item->users->name }}
</td>
--}}