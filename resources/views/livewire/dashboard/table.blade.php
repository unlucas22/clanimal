<x-slot name="title">{{ $title ?? 'Panel' }}</x-slot>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $title ?? 'Panel' }}
    </h2>
</x-slot>

<div>
    @isset($description) <div class="px-2 pt-1">{{ $description }}</div> @endisset
    <div class="py-4">
        @isset($head_name)
        <div class="flex justify-between pt-4 px-4">
                @include('components.head.'.$head_name)
        </div>
        @endisset
        <div class="flex justify-between pt-8 px-4">
            @foreach($filters as $index => $key)
            <div>
                <label for="{{ $index }}filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar {{$key ?? '' }}</label>
                <input type="text" id="{{ $index }}filter" wire:model="{{ $index }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
            </div>
            @endforeach
            @if(count($items) > 24)
            <div>
                {{ $items->links() }}
            </div>
            @endif
        </div>
        
        <div class="overflow-x-auto sm:overflow-hidden mt-10 sm:mt-5">
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
                        <th scope="col" class="{{ $colStyle }}" style="max-width: 250px;">
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

                            @if($relationship_name !== null)
                                @include('components.relationships.'.$relationship_name, ['item' => $item, 'td' => $td ])
                            @else

                                @include('components.relationships.'.$table, ['item' => $item, 'td' => $td ])
                            @endif
                        @endif

                        @if($created_at)
                        <td class="{{ $td }}">
                            {{ $item->created_at->format('d/m/Y'); }}
                        </td>
                        @endif
                        @if($updated_at)
                        <td class="{{ $td }}">
                            {{ $item->updated_at->format('d/m/Y'); }}
                        </td>
                        @endif
                        <td class="py-4 px-1 flex justify-center">

                            <div class="flex justify-between gap-2" style="max-width: 250px;">
                            @if($can_delete)
                                <div>
                                <a data-tooltip="{ 'offset': 10 }" title="delete" wire:click="deleteItem({{$item->id}})" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 cursor-pointer">Eliminar</a>
                                </div>
                                @endif
                                @isset($action_name)
                                @include('components.actions.'.$action_name, ['item' => $item])
                                @endisset
                            </div>
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
</div>