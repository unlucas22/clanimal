<td class="{{ $td }}">
    {{ $item->fecha->format('m - Y') }}
</td>

<td class="{{ $td }}">
    {{ count($item->user_for_spreadsheets) }}
</td>

<td class="{{ $td }}">
    @php($total = 0)
    @foreach($item->user_for_spreadsheets as $user)
    @php($total += $user->total)
    @endforeach

    S/ {{ $total }} Soles
</td>

<td class="{{ $td }}">
    {!! $item->formatted_status !!}
</td>

<td class="{{ $td }}">
    @if($item->validated_at !== null)
    {{ $item->validated_at->format('d/m/Y h:i A') }}
    @endif
</td>