<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Crear Planilla
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="submit" class="space-y-4 p-4">

                <div>Seleccionar Mes y Año de plantilla a generar</div>

                <div class="flex justify-between gap-4">
                    <div class="w-full">
                        <label for="ss45" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mes</label>
                        <select id="ss45" name="month_selected" wire:model.defer="month_selected" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($months as $month => $name)
                            <option value="{{ $month }}" @if($loop->first) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="ss44" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Año</label>
                        <select id="ss44" name="year_selected" wire:model.defer="year_selected" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach($years as $year)
                            <option value="{{ $year }}" @if($loop->first) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>