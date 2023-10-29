<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Generar Turno para Mascota
    </h2>
</x-slot>

<div class="pt-8">
    <div class="bg-white shadow rounded-lg max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8  mx-auto">
        <div class="mt-12">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white mt-8">Generar turno</h2>

            <form method="POST" action="{{ route('dashboard.store.shift') }}" class="space-y-10">

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
                                <option value="0">Sin mascotas registradas.</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <caption class="p-5 text-lg font-semibold text-center text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                    Turnos del día
                                </caption>
                                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                            Hora
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Mascota
                                        </th>
                                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                            Servicio
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tablaTurnos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mb-8 lg:mb-16 font-semibold text-center text-gray-500 sm:text-xl">Día y Hora</div>

                <div class="flex justify-center gap-8">
                    <div class="flex justify-center">

                        <div class="relative max-w-sm">
                          <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                             <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                              </svg>
                          </div>
                          <input datepicker datepicker-format="mm/dd/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="datepicker" placeholder="Seleccionar Fecha" name="fecha" id="fecha" onchange="handler(event);">
                        </div>
                    </div>
                    <div>
                        <input type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="selecciona la hora" name="hora"  value="{{ old('hora') ?? now()->format('H:i') }}" min="06:00" max="20:00" required>
                    </div>
                </div>

                <script>

                window.onload = function(){
                    const datepickerEl = document.getElementById('datepicker');
                    
                    new Datepicker(datepickerEl, {
                        // options
                    });

                    getTableTurnos();

                    datepickerEl.addEventListener('changeDate', (event) => {
                        getTableTurnos(event.detail.date);
                    });
                }

                function getTableTurnos(fecha = null) {

                    var token = $('meta[name="csrf-token"]').attr('content');

                    console.log(fecha);

                    var datos = {
                        _token: token,
                        fecha: fecha,
                    };

                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: '{{ route('api.get.shifts') }}',
                        type: 'POST',
                        data: datos,
                        success: function(response) {
                            console.log(response);

                            $('#tablaTurnos').empty();
                            
                            var tabla = $('#tablaTurnos');


                            response.forEach(function(turno) {
                                var fila = '<tr class="border-b border-gray-200 dark:border-gray-700">' +
                                '<td class="px-4 py-2 text-center">' + turno.hora + '</td>' +
                                '<td class="px-4 py-2 text-center">' + turno.pet_name + '</td>' +
                                '<td class="px-4 py-2 text-center">' + turno.service + '</td>' +
                                '</tr>';
                            tabla.append(fila);
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error('Estado: ', status);
                            console.error('Error: ', error);
                        }
                    });
                }
                </script>

                <div class="p-4">
                    <x-jet-button>
                        {{ __('Agendar') }}
                    </x-jet-button>                
                </div>

            </form>

        </div>
    </div>
</div>
</x-app-layout>