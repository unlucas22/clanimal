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
            @if(Cookie::has('qr_validation'))
            <x-form.input :type="'text'" :name="'user_dni'" :model="'user_dni'" :label="'Número de DNI'" :required="'disabled'" />
            @else
            <x-form.input :type="'text'" :name="'user_dni'" :model="'user_dni'" :label="'Número de DNI'" :required="'required'" />
            @endif
            @error('user_dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mt-4">

            <label for="ss4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo</label>
            <select id="ss4" wire:model.defer="motivo_id" :value="old('motivo')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @forelse($motivos as $motivo)
                <option value="{{ $motivo->id }}" @if($motivo->id == 1) selected @endif>{{ $motivo->name }}</option>
                @empty
                <option value="0" selected>Error: Sin Motivos establecidos.</option>
                @endforelse
            </select>
            @error('motivo_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mt-4">

            <label for="ss4w" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sede</label>
            <select id="ss4w" wire:model.defer="company_id" :value="old('company_id')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @forelse($sedes as $sede)
                <option value="{{ $sede->id }}" @if($sede->id == 1) selected @endif>{{ $sede->name.' ('.$sede->address.').' }}</option>
                @empty
                <option value="0" selected>Error: Sin Sedes establecidos.</option>
                @endforelse
            </select>
            @error('company_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
