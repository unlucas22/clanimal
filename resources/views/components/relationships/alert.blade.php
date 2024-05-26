<td class="{{ $td }}" style="max-width: 300px;">
    {{ $item->message }}
</td>
<td class="{{ $td }}">
    {!! $item->type_formatted !!}
</td>
<td class="{{ $td }}">
    {{ $item->notices_count }}
</td>
<td class="{{ $td }}">
    {!! $item->email_formatted  !!}
</td>