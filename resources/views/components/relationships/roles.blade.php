<td class="{{ $td }}">
    @forelse($item->permissions as $permission)
    {{ $permission->name }},
    @empty
    Sin accesos definidos.
    @endforelse
</td>
{{-- 
<td class="{{ $td }}">
    @forelse($item->permissions as $permission)
    {{ $permission->description }}
    @empty
    Sin descripción
    @endforelse
</td>
 --}}
<td class="{{ $td }}">
    {{ $item->users_count ?? 0 }}
</td>