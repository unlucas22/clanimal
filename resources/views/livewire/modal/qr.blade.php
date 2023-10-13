<div class="p-6">
    <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Ingrese su cedula para obtener el QR</h2>

    <form wire:submit.prevent="submit" class="space-y-10 pt-8">

        <div class="relative z-0 w-full mb-6 group">
            <x-form.input :type="'text'" :name="'user_dni'" :model="'user_dni'" :label="'Cedula'" :required="'required'" />
            @error('user_dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        @if($link !== null)
        <div>
            <div class="flex justify-center">
                <div class="p-2">
                    {!! DNS2D::getBarcodeHTML("{$link}", 'QRCODE') !!}
                </div>
            </div>

            <div class="pt-4">
                Escanea el QR o bien haz <a href="{{ $link }}" class="font-bold">click aquí</a> para dar el checkout
            </div>

        </div>
        @else
        <x-jet-button class="ml-4">
            {{ __('Obtener QR') }}
        </x-jet-button>
        @endif
    </form>
</div>