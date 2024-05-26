<div id="side-navigation">

    <div>
        <aside id="default-sidebar" class="fixed top-0 left-0 {{-- z-40 --}} w-48 h-screen transition-transform -translate-x-full sm:translate-x-0" style="min-width:250px;" aria-label="Sidenav">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <ul class="space-y-2" style="padding-top: 80px;">


                    <x-hr :content="'Logística General'" />

                    <li>
                        <a href="{{ route('dashboard.products') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.products')
                            ])>
                            <x-icons.heroicons.gift :class="'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900'" />
                            <span class="ml-3">Productos</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.compras') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.compras')
                            ])>
                            <x-icons.heroicons.money :class="'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900'" />
                            <span class="ml-3">Ingresos</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('dashboard.transfers') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.transfers')
                            ])>
                            <x-icons.heroicons.house />
                            <span class="ml-3">Salida</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.suppliers') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.suppliers')
                            ])>
                            <x-icons.heroicons.db />
                            <span class="ml-3">Proveedores</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.stock') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.stock')
                            ])>
                            <x-icons.flowbite.overview />
                            <span class="ml-3">Stock</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.packs') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.packs')
                            ])>
                            <x-icons.heroicons.fire />
                            <span class="ml-3">Ofertas</span>
                        </a>
                    </li>

                    <x-hr :content="'Logística de Tienda'" />

                    <li>
                        <a href="{{ route('dashboard.stock-de-tienda') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.stock-de-tienda')
                            ])>
                            <x-icons.heroicons.house />
                            <span class="ml-3">Stock de tienda</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.ingreso-de-productos') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.ingreso-de-productos')
                            ])>
                            <x-icons.heroicons.house />
                            <span class="ml-3">Ingresos de Productos</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.productos-de-tienda') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.productos-de-tienda')
                            ])>
                            <x-icons.heroicons.gift :class="'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900'" />
                            <span class="ml-3">Productos de Tienda</span>
                        </a>
                    </li>

                    <x-hr :content="'Gerencia'" />

                    <li>
                        <a href="{{ route('dashboard.manager') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.manager')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Resumen</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.ingresos-gerencia') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.ingresos-gerencia')
                            ])>
                            <x-icons.flowbite.overview />
                            <span class="ml-3">Ingresos</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.salidas-gerencia') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.salidas-gerencia')
                            ])>
                            <x-icons.flowbite.overview />
                            <span class="ml-3">Salidas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.controls') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.controls')
                            ])>
                            <x-icons.heroicons.qr />
                            <span class="ml-3">Control de Colaboradores</span>
                        </a>
                    </li>

                    <x-hr :content="'Finanzas'" />

                    {{-- 
                    <li>
                        <a href="{{ route('dashboard.finanzas') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.finanzas')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Resumen</span>
                        </a>
                    </li>
                     --}}

                    <li>
                        <a href="{{ route('dashboard.finanzas-ingresos') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.finanzas-ingresos')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Ingresos</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.finanzas-planillas') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.finanzas-planillas')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Planillas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.finanzas-facturas') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.finanzas-facturas')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Facturas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.cuentas-por-pagar') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.cuentas-por-pagar')
                            ])>
                            <x-icons.heroicons.money />
                            <span class="ml-3">Cuentas Por Pagar</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.cuentas-por-cobrar') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.cuentas-por-cobrar')
                            ])>
                            <x-icons.heroicons.money />
                            <span class="ml-3">Cuentas Por Cobrar</span>
                        </a>
                    </li>

                    {{-- 
                    <li>
                        <a href="#" disabled @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.finanzas-facturas')
                            ])>
                            <x-icons.heroicons.money />
                            <span class="ml-3">Reporte</span>
                        </a>
                    </li>

                     --}}

                    <x-hr :content="'RRHH'" />

                    <li>
                        <a href="{{ route('dashboard.recursos-humanos') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.recursos-humanos')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Colaboradores</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.rrhh-planillas') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.rrhh-planillas')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Planillas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.puestos') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.puestos')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Puestos y Sueldos</span>
                        </a>
                    </li>

                    <x-hr :content="'Ventas'" />

                    @if(Auth::user()->isCajaOpen())
                    <li>
                        <a href="{{ route('dashboard.sales') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.sales')
                            ])>
                            <x-icons.heroicons.money :class="'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900'" />
                            <span class="ml-3">Ventas</span>
                        </a>
                    </li>
                    @endif

                     @if(\App\Models\Casher::where('user_id', Auth::user()->id)->active()->count())
                    <li>
                        <a href="{{ route('dashboard.caja') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.caja')
                            ])>
                            <x-icons.heroicons.wallet />
                            <span class="ml-3">Caja</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('dashboard.caja-de-cobro') }}" @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.caja-de-cobro')
                            ])>
                            <x-icons.heroicons.money />
                            <span class="ml-3">Créditos</span>
                        </a>
                    </li>

                    <x-hr :content="'Marketing'" />

                    <li>
                        <a href="{{ route('dashboard.marketing-campaigns') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.marketing-campaigns')
                            ])>
                            <x-icons.heroicons.db />
                            <span class="ml-3">Campañas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.marketing-templates') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.marketing-templates')
                            ])>
                            <x-icons.heroicons.db />
                            <span class="ml-3">Plantillas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.marketing-trackings') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.marketing-trackings')
                            ])>
                            <x-icons.heroicons.house />
                            <span class="ml-3">Tracking</span>
                        </a>
                    </li>


                    <x-hr :content="'Recepción'" />

                    <li>
                        <a href="{{ route('dashboard.receptions') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.receptions')
                            ])>
                            <x-icons.heroicons.wallet />
                            <span class="ml-3">Recepción</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.shifts') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.shifts')
                            ])>
                            <x-icons.heroicons.calendar />
                            <span class="ml-3">Citas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.clients') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.clients')
                            ])>
                            <x-icons.heroicons.db />
                            <span class="ml-3">Clientes</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.pets') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.pets')
                            ])>
                            <x-icons.svgrepo.dog :class="'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900'" />
                            <span class="ml-3">Mascotas</span>
                        </a>
                    </li>

                    <x-hr :content="'Operaciones'" />

                    <li>
                        <a href="{{ route('dashboard.atencion-veterinaria') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.atencion-veterinaria')
                            ])>
                            <x-icons.heroicons.house />
                            <span class="ml-3">Atención Veterinaria</span>
                        </a>
                    </li>

                    @if(Auth::user()->role_id == 1)
                    <x-hr :content="'Sistema'" />

                    
                    <li>
                        <a href="{{ route('dashboard.users') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.users')
                            ])>
                            <x-icons.heroicons.user />
                            <span class="ml-3">Colaboradores</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a href="{{ route('dashboard.cajeros') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.cajeros')
                            ])>
                            <x-icons.heroicons.users :class="'w-6 h-6 text-gray-900 transition duration-75 group-hover:text-gray-900'" />
                            <span class="ml-3">Cajas</span>
                        </a>
                    </li>

                    {{-- Productos --}}

                    <li>
                        <a href="{{ route('product.brands') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('product.brands')
                            ])>
                            <x-icons.heroicons.wrench-one />
                            <span class="ml-3">Marcas</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('product.categories') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('product.categories')
                            ])>
                            <x-icons.heroicons.wrench-one />
                            <span class="ml-3">Categorías</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('product.presentations') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('product.presentations')
                            ])>
                            <x-icons.heroicons.wrench-one />
                            <span class="ml-3">Tipo de presentación</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.entidades-bancarias') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.entidades-bancarias')
                            ])>
                            <x-icons.heroicons.wrench-one />
                            <span class="ml-3">Entidades Bancarias</span>
                        </a>
                    </li>

                    {{-- General --}}

                    @if(Auth::user()->role_id == 1)

                    <li>
                        <a href="{{ route('dashboard.sedes') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.sedes')
                            ])>
                            <x-icons.heroicons.wrench />
                            <span class="ml-3">Sedes</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.classifications') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.classifications')
                            ])>
                            <x-icons.heroicons.wrench />
                            <span class="ml-3">Clasificaciones</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.notificaciones') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.notificaciones')
                            ])>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-gray-900">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                            </svg>
                            <span class="ml-3">Notificaciones</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.sistema') }}"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group',
                            'bg-gray-100' => request()->routeIs('dashboard.sistema')
                            ])>
                            <x-icons.heroicons.wrench />
                            <span class="ml-3">Notificaciones</span>
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

                    <li>
                        <a href="#"  @class([
                            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg group'
                            ])>
                            <x-icons.heroicons.users />
                            <span class="ml-3">Footer</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </div>
            <div class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.show') }}" data-tooltip-target="tooltip-settings" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <div id="tooltip-settings" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip">
                    Perfil
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
</div>
