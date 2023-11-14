{{-- @if(!$item->isActive())
<a wire:click="updateVerifiedAt({{$item->id}})" type="button" class="inline-block py-1 px-2 bg-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out mb-4 cursor-pointer">Verificar Correo</a>
@endif
--}}
<div><a wire:click='$emit("openModal", "modal.update.user", @json(["item_id" => $item->id]))' type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer" >Modificar</a></div>

@if($item->histories_count)
<div><a wire:click='$emit("openModal", "modal.history", @json(["item_id" => $item->id]))' type="button" class="inline-block py-1 px-2 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out mb-4 cursor-pointer" >Historial</a></div>
@endif