<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
        <script src="https://unpkg.com/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js"></script>

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white @yield('page-id', 'default-page')" data-theme="light">
        <x-banner />
        <script>
            window.brgy_id = @json($barangayId);
            window.brgy_name = @json($barangayName);
        </script>
        
        <div class="h-screen flex flex-col">
            
            @livewire('navigation-menu')

            <div class="flex flex-1 overflow-hidden"> 
                
                @auth
                    @if(Auth::user()->role_id == 1)
                        @include('partials.mho-sidenav') 
                    @else
                        @include('partials.bhc-sidenav') 
                    @endif
                @endauth

                <main class="flex-1 overflow-y-auto bg-bg_col">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        @stack('modals')
        @include('components.modals.language-modal')
        @include('components.modals.success-modal')
        
        @livewireScripts
        
        {{-- Alpine.js Global Store --}}
        <script>
            document.addEventListener('alpine:init', () => {
                // Global store for sidebar state
                Alpine.store('sidebar', {
                    open: false,
                    
                    toggle() {
                        this.open = !this.open;
                    },
                    
                    close() {
                        this.open = false;
                    }
                });
            });
        </script>
        
        @stack('scripts')
    </body>
</html>
