<td class="{{ $td }}">
    {{ $item->pets_count }}
</td>
<td class="{{ $td }}">
    {{-- {{ $item->sales }}  --}} $0
</td>
<td class="{{ $td }}">
    @switch($item->status)

        @case('ocasional')
        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Ocasional</span>
        @break

        @case('regular')
        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Básico</span>
        @break

        @case('VIP')
        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">VIP</span>
        @break

    @endswitch
</td>
{{-- añadir link al seguimiento --}}
<td class="{{ $td }}">
    {{ $item->users->name }}
</td>