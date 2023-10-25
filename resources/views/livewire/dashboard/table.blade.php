<x-slot name="title">{{ $title ?? 'Panel' }}</x-slot>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $title ?? 'Panel' }}
    </h2>
</x-slot>

<div class="py-4">
    @isset($head_name)
    <div class="flex justify-between pt-8 px-4">
            @include('components.head.'.$head_name)
    </div>
    @endisset
    <div class="flex justify-between pt-8 px-4">
        @foreach($filters as $index => $key)
        <div>
            <input type="text" class="px-2 py-1 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full" placeholder="Buscar por {{$key }}" wire:model="{{ $index }}">
        </div>
        @endforeach
        <div>
            <select class="form-control" wire:click="changeRow($event.target.value)">
                @foreach($rows_count as $row)
                <option value="{{ $row }}">{{ $row }}</option>
                @endforeach
            </select>
        </div>
        @if(count($items) > 24)
        <div>
            {{ $items->links() }}
        </div>
        @endif
    </div>
    
    <div class="relative overflow-x-auto sm:overflow-hidden mt-10 sm:mt-5">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 text-center">
                <tr>
                @php($colStyle = 'px-6 py-4')
                    @foreach($columns as $index => $key)
                    <th scope="col" class="{{ $colStyle }}">
                        {{ $key }}
                    </th>
                    @endforeach
                    @foreach($relationships as $column)
                    <th scope="col" class="{{ $colStyle }}">
                        {{ $column }}
                    </th>
                    @endforeach
                    @if($created_at)
                    <th scope="col" class="{{ $colStyle }}">
                        Creado
                    </th>
                    @endif
                    @if($updated_at)
                    <th scope="col" class="{{ $colStyle }}">
                        Actualizado
                    </th>
                    @endif
                    <th scope="col" class="{{ $colStyle }}">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white text-center">
                @php($td = 'px-6 py-4')

                @forelse($items as $item)
                <tr 
                @if($canActive)
                    @if(!$item->isActive())
                    class="bg-gray-200 hover:bg-red-50"
                    @else
                    class="hover:bg-red-50"
                    @endif

                @endif
                >
                    @foreach($columns as $index => $key)
                        <td class="{{ $td }}">
                            {{ $item->$index }}
                        </td>
                    @endforeach

                    @if(count($relationships) != null)
                        @include('components.relationships.'.$table, ['item' => $item, 'td' => $td ])
                    @endif

                    @if($created_at)
                    <td class="{{ $td }}">
                        {{ $item->created_at->format('d M Y'); }}
                    </td>
                    @endif
                    @if($updated_at)
                    <td class="{{ $td }}">
                        {{ $item->updated_at->format('d M Y'); }}
                    </td>
                    @endif
                    <td class="{{ $td }}">
                        <a data-tooltip="{ 'offset': 10 }" title="delete" wire:click="deleteItem({{$item->id}})" type="button" class="inline-block py-1 px-2 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"><x-icons.heroicons.trash /></a>

                        @isset($action_name)
                        @include('components.actions.'.$action_name, ['item' => $item])
                        @endisset

                    </td>
                </tr class="bg-white border-b">
                @empty
                <tr class="text-center py-3">
                    <td colspan="{{ $columns_count }}" class="py-3 italic">No hay Items</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>