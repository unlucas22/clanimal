<div>
	<a wire:click='$emit("openModal", "modal.update.cuentas-por-pagar", @json(["item_id" => $item->id]))'>
        <x-btn :content="'Pagar'" />
    </a>

    <script>
        function callPagarCuota(item_id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez que pagas la cuenta no lo podrás retornar su estado",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, pagar'
            }).then(function (res) {
                if (res.isConfirmed) {
                    Livewire.emit('pagarCuota', item_id);

                    Livewire.emit('refreshComponent');
                }
            });
        }
    </script>
</div>