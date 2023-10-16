@if(!$item->isActive())
<a wire:click="updateConfirmed({{$item->id}})" type="button" class="inline-block py-1 px-2 bg-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out"><x-icons.heroicons.check /></a>
@endif

<a wire:click='$emit("openModal", "modal.update.control", @json(["item_id" => $item->id]))' type="button" class="inline-block py-1 px-2 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" ><x-icons.heroicons.pencil /></a>