<div>
	@if(\App\Models\CashRegister::where('casher_id', Auth::user()->id)->orderBy('created_at', 'desc')->where('closed_at', null)->count())
	@else
	<div>
		<a wire:click='$emit("openModal", "modal.store.abrir-caja")'>
			<x-btn :content="'Abrir Caja'" />
		</a>
	</div>
	@endif

	<script>
        function cancelCajaButton() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez que cerras la caja no lo podrás abrir nuevamente",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, cerrar'
            }).then(function (res) {
                if (res.isConfirmed) {
                    Livewire.emit('cerrarCaja');

                    Livewire.emit('refreshComponent');
                }
            });
        }
    </script>
</div>