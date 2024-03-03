<td class="{{ $td }}">
    {{ $item->roles->name }}
</td>
<td class="{{ $td }}">
    {{ $item->companies->name ?? '' }}
</td>
<td class="{{ $td }}">
@if($item->active)
<div class="flex items-center">
     <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Activo
</div>
@else
<div class="flex items-center">
     <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Inactivo
</div>
@endif
</td>