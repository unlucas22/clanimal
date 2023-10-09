@props(['active', 'sound'])
@php($td = 'text-sm text-gray-900 font-light px-1 py-2 whitespace-nowrap')

@forelse($items as $item)
<tr 
    @if($active)
        class="border-b bg-white"
    @else
        class="border-b bg-red-100 border-red-200"
    @endif
>
    <td class="{{ $td }}">
        {{ $sound->name }}
    </td>
    <td class="{{ $td }}">
        {{ $sound->created_at->format('M d Y'); }}
    </td>
    <td class="{{ $td }}">
        {{ $sound->updated_at->format('M d Y'); }}
    </td>
    <td class="{{ $td }}">
        {{ $actions }}
    </td>
</tr class="bg-white border-b">

@endforelse