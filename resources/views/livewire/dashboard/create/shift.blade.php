<div class="flex justify-center pt-8">
    <form method="POST" action="{{ route('dashboard.store.shift') }}" class="space-y-10">
    
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Programación de citas para mascotas
            </h3>

            <x-btn-retorno-default />
        </div>
        
        @csrf

        <div>
            <label for="default-search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">DNI</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Agregar Texto" wire:model.defer="dni" name="dni" min="8" max="8">
                <a class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer" wire:click="searchClient">Buscar</a>
            </div>
        </div>

        <x-form.input :label="'Cliente'" :name="'client'" :model="'client'" :placeholder="'Buscar primero por DNI'" :required="'disabled'" />

        <div>
            <!-- Mascota -->
            <div class="form-group mb-4">
                <div>  
                    <label for="ss2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mascota</label>
                    <select id="ss2" name="pet_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @forelse($pets as $pet)
                        <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                        @empty
                        <option value="0">Sin mascotas registradas.</option>
                        @endforelse
                    </select>
                </div>

            </div>

            <!-- Servicio -->
            <div class="form-group">

                <label for="ss4" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Especialidad</label>
                <select id="ss4" name="service_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @forelse($services as $service)
                    <option @if($loop->first) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
                    @empty
                    <option value="0">Sin especialidades registradas.</option>
                @endforelse
                </select>
            </div>
        </div>
        <div class="flex justify-center gap-8">
            <div class="flex justify-center">

                <div>
                    <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                    <div class="relative max-w-sm">
                      <div class="absolute flex items-center pl-3 mt-3 pointer-events-none">
                         <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                          </svg>
                      </div>
                      <input datepicker datepicker-format="mm/dd/yyyy" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="datepicker" placeholder="Seleccionar Fecha" name="fecha" id="fecha" value="{{ now()->format('m/d/Y') }}" onchange="handler(event);">
                    </div>
                </div>
            </div>
            <div>
                <label for="hora" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora</label>
                <input type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="selecciona la hora" name="hora" id="hora"  value="{{ old('hora') ?? now()->format('H:i') }}" min="06:00" max="20:00" required>
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

        <div class="p-4 flex justify-center">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">   Guardar
            </button>                
        </div>

    </form>
</div>