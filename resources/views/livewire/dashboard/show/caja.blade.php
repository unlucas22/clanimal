<div>
    
    {{-- Informacion de la compra --}}
    <div class="p-4 text-xl">

        <div class="font-bold">Operaciones del {{ $caja->created_at }}</div>


        <div class="flex justify-between gap-8 pt-8">
            
            <div class="w-full">
                <div class="space-y-8">
                    <div class="flex justify-between gap-8">
                        <div class="font-bold">Cajera</div>
                        <div>{{ $caja->cashers->users->name }}</div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div class="font-bold">Fecha</div>
                        <div>{{ $caja->created_at }}</div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div>
                            <span class="font-bold">Tarjetas</span>
                            <div class="text-base">Pagos con tarjetas de crédito/débito</div>
                        </div>
                        <div>S/ {{ $caja->total_tarjeta ?? 0 }} Soles</div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div>
                            <span class="font-bold">Billeteras electrónicas</span>
                            <div class="text-base">Pagos con Yape, Plin, QR, entre otros</div>
                        </div>
                        <div>S/ {{ $caja->total_virtual ?? 0 }} Soles</div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div>
                            <span class="font-bold">Efectivo</span>
                            <div class="text-base">Pagos con dinero en efectivo</div>
                        </div>
                        <div>S/ {{ $caja->total_efectivo ?? 0 }} Soles</div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div class="font-bold">EN CAJA</div>
                        <div>S/ {{ $caja->en_caja ?? 0 }} Soles</div>
                    </div>

                    <div class="flex justify-between gap-8 font-bold">
                        <div>TOTAL</div>
                        <div>S/ {{ $caja->total ?? 0 }} Soles</div>
                    </div>

                </div>
            </div>

            {{-- Control de operaciones y estado actual --}}
            <div class="w-full">

                @if($caja->closed_at == null)
                <div class="font-bold">Control de Operaciones</div>

                <div class="pt-4 text-base">
                    Luego de finalizar el turno, el personal de Caja realiza la entrega de dinero al Gerente de tienda.
                </div>

                <div class="pt-4 mb-4">

                    <form wire:submit.prevent="submit" class="bg-gray-100 p-6 space-y-8 rounded">
                        <div class="font-bold">Inicio de Operación</div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="total_efectivo" value="{{ __('Efectivo a depositar') }}" />
                            <x-jet-input id="total_efectivo" type="number" class="mt-1 block w-full" wire:model.defer="total_efectivo" autocomplete="total_efectivo" min="0" />
                            <x-jet-input-error for="total_efectivo" class="mt-2" />
                            @error('total_efectivo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="total_tarjeta" value="{{ __('Tarjetas') }}" />
                            <x-jet-input id="total_tarjeta" type="number" class="mt-1 block w-full" wire:model.defer="total_tarjeta" autocomplete="total_tarjeta" min="0" />
                            <x-jet-input-error for="total_tarjeta" class="mt-2" />
                            @error('total_tarjeta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="total_virtual" value="{{ __('Billeteras electrónicas') }}" />
                            <x-jet-input id="total_virtual" type="number" class="mt-1 block w-full" wire:model.defer="total_virtual" autocomplete="total_virtual" min="0" />
                            <x-jet-input-error for="total_virtual" class="mt-2" />
                            @error('total_virtual') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="en_caja" value="{{ __('Resta en Caja') }}" />
                            <x-jet-input id="en_caja" type="number" class="mt-1 block w-full" wire:model.defer="en_caja" disabled />
                            <x-jet-input-error for="en_caja" class="mt-2" />
                        </div>

                        <div class="items-center p-2 border-t flex justify-center border-gray-200 rounded-b dark:border-gray-700">
                            <button id="submit" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Depositar
                            </button>
                        </div>

                    </form>                    
                </div>

                @endif

                <div class="bg-gray-100 p-6 space-y-8 rounded">
                    <div class="flex justify-between gap-8">
                        <div class="font-bold">
                            Estado de Operación
                        </div>
                        <div>
                            {!! $caja->formatted_status !!}
                        </div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div class="font-bold">
                            Fecha
                        </div>
                        <div>
                            {{ $caja->updated_at->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="flex justify-between gap-8">
                        <div class="font-bold">
                            Hora
                        </div>
                        <div>
                            {{ $caja->updated_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
