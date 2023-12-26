<div class="flex justify-between gap-8">
	<div>
		<a wire:click='$emit("openModal", "modal.store.marketing-campaigns")'>
			<x-btn-nuevo/>
		</a>
	</div>

	<div><a wire:click="ejecutarJob">
	<x-btn :content="'Ejecutar (job - test)'" /></a></div>
</div>