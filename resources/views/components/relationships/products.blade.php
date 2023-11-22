<td class="{{ $td }}">
    @if($item->photo_url !== null)
    <img class="w-20 h-20 rounded" src="{{ $item->photo_path }}">
    @endif
</td>
<td class="{{ $td }}">
    {{ $item->product_brands->name }}
</td>
<td class="{{ $td }}">
    {{ $item->product_categories->name }}
</td>
<td class="{{ $td }}">
    0
</td>