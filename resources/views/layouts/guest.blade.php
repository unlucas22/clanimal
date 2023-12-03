<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <div class="font-sans text-gray-900 antialiased">
                {{ $slot }}
            </div>

            <div class="text-center"><footer class="px-4 sm:px-6 lg:px-8 mt-10"><div class="border-t border-slate-200 pt-10 pb-16 dark:border-slate-200/5"><div class="text-center"><p class="mt-4 text-sm leading-6 text-slate-500">© <!-- -->{{ date('Y') }}<!-- --> {{ config('app.name', 'Laravel') }} | All rights reserved.</p></div></div></footer></div>
        </div>
        
        @stack('modals')

        @livewireScripts

        @livewire('livewire-ui-modal')
    </body>
</html>
