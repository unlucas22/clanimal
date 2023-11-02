@if(!$item->isActive())
<div><a wire:click="updateConfirmed({{$item->id}})" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Confirmar acceso</a></div>
@endif
<div>
<a wire:click='$emit("openModal", "modal.update.control", @json(["item_id" => $item->id]))' type="button" class="inline-block py-1 px-2 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out mb-4 cursor-pointer" >Editar</a></div>