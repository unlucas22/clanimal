<div class="flex justify-start">
	<a href="{{ route('dashboard.create.shift') }}">
		<x-jet-button>
	        Nueva cita
	    </x-jet-button>
	</a>
</div>
<div>
	<script>
		function callCancelButton(item_id) {
			Swal.fire({
	            title: '¿Estás seguro?',
	            text: "Una vez que cancelas el turno no podrás retornar a su estado original",
	            type: 'warning',
	            showCancelButton: true,
	            confirmButtonColor: '#3085d6',
	            cancelButtonColor: '#d33',
	            confirmButtonText: 'Si, cancelar turno'
	        }).then(function (res) {
	            if (res.isConfirmed) {
	                Livewire.emit('cancel', item_id);
	            }
	        });
		}
	</script>
</div>