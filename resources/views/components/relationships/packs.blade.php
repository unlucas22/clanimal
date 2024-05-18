<td class="{{ $td }}">
    <ul>
  @foreach($item->product_for_packs as $product)<li>{{ $product->products->name }}</li>@endforeach
    </ul>
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