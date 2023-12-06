<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ url('images/favicon.ico') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">

         <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>

        <style>
            @font-face {
                font-family: Inter;
            }

            html{
                -webkit-text-size-adjust:100%;font-feature-settings:normal;font-family:Inter,ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5;-moz-tab-size:4;-o-tab-size:4;tab-size:4;
            }
        </style>

        @if (isset($head))
        {{ $head }}
        @endif
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <div class="font-sans text-gray-900 antialiased">
                {{ $slot }}
            </div>
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
