<div x-data="{ open: false }" id="side-navigation">
    
    {{-- 

    ESTO ES SOLO PARA MOBILE 

    Bug en mobile: cuando se da click se ve un fondo oscuro de flowbite, hay una funcion que no se está aplicando de flowbite

    --}}
    <button @click="open = ! open" data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Abrir sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>


    <div :class="{'block': open, 'hidden': ! open}" class="hidden">
        <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <ul class="space-y-2">


                    @if(!\Agent::isMobile())
                    <li>
                        <a @click="open = ! open" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <x-icons.heroicons.arrow-left />

                        </a>
                    </li>
                    @endif
                    
                    <li>
                        <img class="w-full" src="{{ asset('img/logo.jpeg') }}">
                    </li>

                    <li>
                        <a href="{{ route('dashboard.index') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.index')
                            ])>
                            <x-icons.flowbite.overview />
                            <span class="ml-3">General</span>
                        </a>
                    </li>
                    @if(Auth::user()->role_id == 1)
                    <li>
                        <a href="{{ route('dashboard.users') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.users')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.roles') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.roles')
                            ])>
                            <x-icons.heroicons.users />
                            <span class="ml-3">Roles y Permisos</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('dashboard.clients') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.clients')
                            ])>
                            <x-icons.heroicons.db />
                            <span class="ml-3">Clientes y Mascotas</span>
                        </a>
                    </li>
                </ul>
                <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                    <li>
                        <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>

                            <span class="ml-3">Notificaciones</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.show') }}" data-tooltip-target="tooltip-settings" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <div id="tooltip-settings" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip">
                    Settings page
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <a href="{{ route('logout') }}" @click.prevent="$root.submit();" data-tooltip-target="tooltip-logout" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>

                    </a>
                    <div id="tooltip-logout" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip">
                        Salir de sesión
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </form>
            </div>
        </aside>
    </div>

    {{--  



    PC VIEW 



    --}}
    <div :class="{'hidden': open, 'block': ! open}">
        <aside id="default-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">

                {{--  ACA IRIA EL LOGO --}}
                <ul class="space-y-2">
                    <li>
                        <a @click="open = ! open" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <x-icons.heroicons.arrow-right />
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.index') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg  hover:bg-gray-100 group',
                            'bg-gray-100' => request()->routeIs('dashboard.index')
                            ])>
                            <x-icons.flowbite.overview />
                        </a>
                    </li>
                    @if(Auth::user()->role_id == 1)
                    <li>
                        <a href="{{ route('dashboard.users') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg  hover:bg-gray-100 group',
                            'bg-gray-100' => request()->routeIs('dashboard.users')
                            ])>
                            <x-icons.heroicons.user />
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.roles') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.roles')
                            ])>
                            <x-icons.heroicons.users />
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('dashboard.clients') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.clients')
                            ])>
                            <x-icons.heroicons.db />
                        </a>
                    </li>
                </ul>
                <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                    <li>
                        <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.show') }}" data-tooltip-target="tooltip-settings" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <div id="tooltip-settings" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip">
                    Configuración
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>
        </aside>
    </div>
</div>
