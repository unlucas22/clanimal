<td class="{{ $td }}">
    {{ $item->pets_count }}
</td>
<td class="{{ $td }}">
    {{-- {{ $item->sales }}  --}} $0
</td>
<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>
{{-- añadir link al seguimiento --}}
<td class="{{ $td }}">
    {{ $item->users->name }}
</td>