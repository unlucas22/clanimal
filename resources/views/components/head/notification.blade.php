<div class="flex justify-start">
	<a wire:click='$emit("openModal", "modal.store.notification")'>
		<x-btn-nuevo/>
	</a>
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
</div>
