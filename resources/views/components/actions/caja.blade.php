<div>
	@if($item->closed_at == null)

	<div>
		<a href="{{ route('dashboard.show.caja', ['hashid' => $item->hashid]) }}" type="button" id="deleteProductButton" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
	    Cerrar</a>
	</div>
	@else
	<a href="{{ route('dashboard.show.caja', ['hashid' => $item->hashid]) }}"><x-btn/></a>
	@endif
</div>