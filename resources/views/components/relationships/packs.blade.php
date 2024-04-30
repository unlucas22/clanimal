<td class="{{ $td }}">
    <textarea class="w-full">@foreach($item->product_for_packs as $product){{ $product->products->name }}. @endforeach</textarea>
</td>
<td class="{{ $td }}">
    {{ $item->fecha_inicio }}
</td>
<td class="{{ $td }}">
    {{ $item->fecha_final }}
</td>
<td class="{{ $td }}">
    S/ {{ $item->precio }} Soles
</td>