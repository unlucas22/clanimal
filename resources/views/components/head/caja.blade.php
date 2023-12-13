<div>

	@if(\App\Models\CashRegister::where('casher_id', Auth::user()->id)->orderBy('created_at', 'desc')->where('closed_at', null)->count())
	<div>
	    <button type="button" onclick="cancelCajaButton()" id="cancelCajaButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
	        Cerrar caja
	    </button>
	</div>
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