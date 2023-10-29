<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Recepción
    </h2>
</x-slot>

<div class="pt-8">
    <div class="bg-white shadow rounded-lg max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8  mx-auto">
        <div class="mt-12">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Recepción</h2>

            <form method="POST" action="{{ route('dashboard.store.reception') }}" class="space-y-10">

                @csrf

                <div class="flex justify-center gap-8">
                    <div>
                        <!-- Mascota -->
                        <div class="form-group mb-4">
                            <label for="ss2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Mascota</label>
                            <select id="ss2" class="w-full form-control" name="pet_id">
                                @if($pet !== null)
                                <option value="{{ $pet->id }}" selected>{{ $pet->name }}</option>
                                @else
                                @forelse($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                                @empty
                                <option value="0">Sin mascotas registradas.</option>
                                @endforelse
                                @endif
                            </select>
                        </div>

                        <!-- Servicio -->
                        <div class="form-group">
                            <label for="ss4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Servicio</label>
                            <select id="ss4" class="w-full form-control" name="service_id">
                                @forelse($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @empty
                                <option value="0">Sin servicios registrados.</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div>
                        <!-- Turnos del día -->
                        <div class="form-group mb-4">
                            <label for="ss4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Turnos del día</label>
                            <select id="ss4" class="w-full form-control" name="shift_id">
                                @forelse($shifts as $shift)
                                <option value="{{ $shift->id }}">{{ $shift->pets->name.' - '.$shift->services->name.' - '.$shift->appointment->format('H:i') }}</option>
                                @empty
                                <option value="0" selected>Sin turnos en el día.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hora" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Hora de ingreso</label>
                            <input type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="selecciona la hora" id="hora" name="hora"  value="{{ old('hora') ?? now()->format('H:i') }}" min="06:00" max="20:00" required>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <x-jet-button>
                        {{ __('Registrar') }}
                    </x-jet-button>                
                </div>

            </form>

        </div>
    </div>
</div>
</x-app-layout>