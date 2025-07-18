<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-bg_col">
        <x-banner />

        <div class="min-h-screen bg-bg-col flex">
            @auth
                @if(Auth::user()->role == 1)
                    @include('partials.sidenav') <!-- Admin sidebar -->
                @else
                    @include('partials.bhc-sidenav') <!-- Non-admin sidebar -->
                @endif
            @endauth

            <!-- Main Content - Fixed to screen height -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                <!-- Scrollable Page Content -->
                 @livewire('navigation-menu')
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
