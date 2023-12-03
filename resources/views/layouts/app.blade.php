<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Inicio' }}</title>

        <link rel="icon" type="image/x-icon" href="{{ url('images/favicon.ico') }}">

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">

        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        @if (isset($head))
        {{ $head }}
        @endif

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <style>

            @font-face {
                font-family: Inter;
            }

            html{
                -webkit-text-size-adjust:100%;font-feature-settings:normal;font-family:Inter,ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-50">
            {{-- @livewire('navigation-menu')  --}}

            @if(Auth::check())
            @livewire('side-navigation')
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow fixed w-full">
                    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">

                        <div class="flex justify-between">
                            <div><img width="170" src="{{ asset('img/logo.jpeg') }}"></div>

                            <div class="flex justify-end py-4">
                                <div class="mt-1">{{ $header }}</div>

                                <div style="margin-left: 50px;">
                                    <div class="flex items-center ml-3">
                                        <div>
                                          <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                                            <span class="sr-only">Open user menu</span>
                                            <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="user photo">
                                          </button>
                                        </div>
                                        
                                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-2" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1652.5px, 61.25px);" data-popper-placement="bottom">
                                          <div class="px-4 py-3" role="none">
                                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                              {{ Auth::user()->name }}
                                            </p>
                                            <p class="text-sm font-semibold text-gray-900 truncate dark:text-gray-300" role="none">
                                              {{ Auth::user()->email }}
                                            </p>
                                          </div>
                                          <ul class="py-1" role="none">
                                            <li>
                                              <a href="{{ url('user/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Configuración</a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="text-center px-4 sm:px-6 lg:px-8 mt-10"><div class="border-t border-slate-200 pt-10 pb-16 dark:border-slate-200/5"><div class="text-center"><p class="mt-4 text-sm leading-6 text-slate-500">© <!-- -->{{ date('Y') }}<!-- --> {{ config('app.name', 'Laravel') }} | Todos los derechos reservados.</p></div></div></footer>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
            window.addEventListener('swal', e => {
                Swal.fire({
                    title: e.detail.title,
                    icon: e.detail.icon,
                    iconColor: e.detail.iconColor,
                    timer: 2000,
                    toast: true,
                    position: 'top-right',
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            });
        </script>

        @livewire('livewire-ui-modal')
    </body>
</html>
