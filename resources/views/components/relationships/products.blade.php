<td class="{{ $td }}">
    @if($item->photo_url !== null)
    <a href="#" onclick="showModal('{{  url('storage/'.$item->photo_path) }}')"><img class="w-20 h-20 rounded" src="{{ url('storage/'.$item->photo_path) }}"></a>
    @else
    Sin imagen
    @endif
</td>

<td class="{{ $td }}">
    {{ $item->product_categories->name ?? 'Sin categoría' }}
</td>

<td class="{{ $td }}">
    {{ $item->product_brands->name ?? 'Sin marca' }}
</td>

<td class="{{ $td }}">
    {{ $item->name }}
</td>

{{-- 
<td class="{{ $td }}">
    {{ $item->stock }}
</td>
 --}}
<td class="{{ $td }}">
    {!! $item->formatted_active !!}
</td>