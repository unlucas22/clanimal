@php($rol = Auth::user()->roles->key)

<div class="py-0 sm:py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            {{-- REDIRECT ???  --}}
            @break

    @endswitch
    </div>
</div>