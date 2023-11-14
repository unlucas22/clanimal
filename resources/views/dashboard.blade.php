<x-app-layout>
    <div class="py-12 flex justify-end">
        <div class="max-w-7xl w-full px-2">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire(\Request::route()->getName())
            </div>
        </div>
    </div>
</x-app-layout>
