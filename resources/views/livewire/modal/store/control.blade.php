<div class="p-6">
    <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Registro Manual de Colaborades</h2>

    <form wire:submit.prevent="submit" class="space-y-4">

        <!-- dni -->
        <div>
            <label for="ssinput" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de DNI</label>
            <input list="cedulas" type="text" id="ssinput" wire:model="dni" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            <datalist id="cedulas">
                @foreach($users as $user)
                <option value="{{ $user->dni }}">{{ $user->dni }}</option>
                @endforeach
            </datalist>
        </div>
        @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

        <div>
            <label for="ss45" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo</label>
            <select id="ss45" name="motivo_id" wire:model.defer="motivo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @forelse($motivos as $motivo)
                <option value="{{ $motivo->id }}" @if($motivo->id == 1) selected @endif>{{ $motivo->name }}</option>
                @empty
                <option value="0" selected>Error: Sin Motivos establecidos.</option>
                @endforelse
            </select>
        </div>

        <div class="form-group">
            <label for="hora" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Hora</label>
            <input type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="selecciona la hora" id="hora" name="hora"  value="{{ old('hora') ?? now()->format('H:i') }}" min="06:00" max="20:00" required>
        </div>

        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            <x-jet-button>
                Crear
            </x-jet-button>
        </div>
    </form>
</div>
