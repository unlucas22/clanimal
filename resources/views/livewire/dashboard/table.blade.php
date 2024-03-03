<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">

                @isset($description)
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                      <li class="inline-flex items-center">
                        <div class="inline-flex items-center text-gray-700  dark:text-gray-300 dark:hover:text-white">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                          {{ $description }}
                        </div>
                      </li>
                    </ol>
                </nav>
                @endisset

                <h1 class="text-xl mt-3 font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ $title ?? 'Panel' }}</h1>
                
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    @isset($search)
                    <div class="sm:pr-3">
                        <label for="searchfilter" class="sr-only">Buscar</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="search" id="searchfilter" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model="search" placeholder="Buscar">
                        </div>
                    </div>
                    @endisset
                </div>

                <div class="flex justify-end">
                    @isset($head_name)
                    <div class="flex justify-between pt-4 px-4">
                        @include('components.head.'.$head_name)
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                @php($colStyle = 'p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400')
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
                                <th scope="col" class="{{ $colStyle }} text-center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        @php($td = 'p-4 text-center text-base font-medium text-gray-900 dark:text-white')

                        @forelse($items as $item)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            @foreach($columns as $index => $key)
                                <td class="{{ $td }}">
                                    {!! $item->$index !!}
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
                                {{ $item->created_at->format('d/m/Y h:i A') }}
                            </td>
                            @endif
                            @if($updated_at)
                            <td class="{{ $td }}">
                                {{ $item->updated_at->format('d/m/Y h:i A') }}
                            </td>
                            @endif
                            <td class="p-4 space-x-2 flex justify-center">

                                <div class="flex justify-between gap-2" style="max-width: 250px;">
                                @if($can_delete)
                                    <div>
                                    <button onclick="callDeleteButton({{ $item->id }})" type="button" id="deleteProductButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Eliminar
                                    </button>
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
                    
                    @if($can_delete)
                    <script>
                        function callDeleteButton(item_id) {
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "Una vez que eliminas no lo podrás recuperar su información",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, eliminar'
                            }).then(function (res) {
                                if (res.isConfirmed) {
                                    Livewire.emit('deleteItem', item_id);

                                    Livewire.emit('refreshComponent');
                                }
                            });
                        }
                    </script>
                    @endif
                </div>
            </div>
        </div>
        {{-- @if(count($items) > 8)  --}}
        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
            {{ $items->links() }}
        </div>
        {{-- @endif  --}}
        {{-- 
            <div class="flex items-center">
                 <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Activo
            </div>

            <div class="flex items-center">
                 <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Inactivo
            </div>'
         --}}
    </div>
</div>