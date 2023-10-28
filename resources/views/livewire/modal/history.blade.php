<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Historial</h2>
    @foreach($histories as $history)
        <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 mb-4">
            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $history->message }}</h5>
            <p class="font-normal text-sm text-gray-700 dark:text-gray-400">Fecha: {{ $history->created_at->format('Y-m-d H:i') }}</p>
        </div>
    @endforeach

    {{-- <div>{{ $histories->links() }}</div> --}}
</div>
