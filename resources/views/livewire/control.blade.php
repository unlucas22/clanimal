<div>
    <form wire:submit.prevent="submit" class="space-y-10 pt-8">

        @if($link !== null)
        <div>
            <div class="text-center font-semibold text-xl">{{ now()->format('H:i A') }}</div>

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

        <div class="relative z-0 w-full mb-6 group">
            <x-form.input :type="'text'" :name="'user_dni'" :model="'user_dni'" :label="'Número de DNI'" :required="'required'" />
            @error('user_dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mt-4">
            <label for="ss4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Motivo</label>
            <select id="ss4" class="w-full form-control" wire:model.defer="motivo_id" :value="old('motivo')">
                @foreach($motivos as $i => $motivo)
                <option value="{{ $i }}" @if($i == 0) selected @endif>{{ $motivo }}</option>
                @endforeach
            </select>
        </div>

        {{-- 
        <div class="mt-4 flex justify-center">
            <div id="recaptcha" style="max-width: 300px;"></div>
            @error('g-recaptcha-response') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
         --}}

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Continuar') }}
            </x-jet-button>
        </div>

        @endif
    </form>
</div>
