@if(!$item->manpowers_count)
<div>
	<button onclick="callDeleteButton({{ $item->id }})" type="button" id="deleteProductButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
	<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
	Eliminar
	</button>
</div>
@endif

<div><a onclick='Livewire.emit("openModal", "modal.update.entidades-bancarias", @json(["item_id" => $item->id]))'>
	<x-btn-edit /></a></div>


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