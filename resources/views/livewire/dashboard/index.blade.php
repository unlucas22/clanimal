@php($rol = Auth::user()->roles->key)

<div class="py-12 flex justify-center px-8">
    <div>
    @switch($rol)

        @case('administrador')
                
                @livewire('dashboard.greeting')

                <h4 class="mt-6 text-gray-500">
                    La sección del panel general de nuestro sistema alberga gráficos interactivos y datos clave en tiempo real. Ofrece visualizaciones de datos, tablas informativas y widgets personalizables para que los usuarios puedan supervisar y analizar de manera efectiva información crítica.
                </h4>

                <div class="mt-14">
                    @livewire('dashboard.charts')
                </div>
            @break

        @default
            {{-- FUTUROS COMPONENTES PARA COLABORADORES  --}}
            @break

    @endswitch
    </div>
</div>