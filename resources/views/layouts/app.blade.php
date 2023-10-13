<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Inicio' }}</title>

        <link rel="icon" type="image/x-icon" href="{{ url('images/favicon.ico') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>

        {{-- 
        <style>
            @font-face {
                font-family: "Inter-Regular";
                src: url('{{ asset('fonts/Inter-Regular.ttf') }}');
            }

            *{
                font-family: "Inter-Regular";
            }
        </style>
         --}}
        
        @if (isset($head))
        {{ $head }}
        @endif
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            {{-- @livewire('navigation-menu')  --}}

            @if(Auth::check())
            @livewire('side-navigation')
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-32"><div class="border-t border-slate-200 pt-10 pb-16 dark:border-slate-200/5"><div class="text-center"><p class="mt-4 text-sm leading-6 text-slate-500">© <!-- -->{{ date('Y') }}<!-- --> {{ config('app.name', 'Laravel') }} | All rights reserved.</p></div></div></footer>
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
