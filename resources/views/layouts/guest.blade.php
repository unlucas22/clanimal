<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">

         <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>

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

        @livewire('livewire-ui-modal')
    </body>
</html>
