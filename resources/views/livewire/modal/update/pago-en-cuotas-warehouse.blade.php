<div>

    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Detalles
                </h3>
                <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4 p-4" id="form">

                <div class="flex justify-between">
                    <div class="font-bold">
                        Razón Social
                    </div>
                    <div>
                        {{ $warehouse->suppliers->name }}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        RUC
                    </div>
                    <div>
                        {{ $warehouse->suppliers->ruc }}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        {{ $warehouse->suppliers->banco }}
                    </div>
                    <div>
                        {{ $warehouse->suppliers->cuenta_bancaria }}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        TOTAL A PAGAR
                    </div>
                    <div>
                        {!! $warehouse->total_formatted !!}
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="font-bold">
                        Pagar en cuotas
                    </div>
                    <div>
                        <select id="cuotas" name="cuotas" wire:model.live="cuotas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @for($i=2; $i<=12; $i++)
                            <option value="{{ $i }}">{{ $i }} cuotas</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    Cuota de S/ {{ round($warehouse->total / $cuotas, 2) }}
                </div>

                <div class="grid gap-4 mb-4 ">

                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" wire:model.defer="motivo"></textarea>
                        @error('motivo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        REALIZAR PAGO
                    </button>
                </div>
            </form>
        </div>
    </div>    
</div>