<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Custom 2026 'Glass' effect for the header */
            .glass-header {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 selection:bg-indigo-100 selection:text-indigo-700">
        <div class="min-h-screen bg-[#fcfcfd]">
            
            <div class="sticky top-0 z-50">
                @include('layouts.navigation')
            </div>

            @isset($header)
                <header class="glass-header sticky top-[65px] z-40">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                                {{ $header }}
                            </h1>
                            </div>
                    </div>
                </header>
            @endisset

            <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
                    {{ $slot }}
                </div>
            </main>
            
            <footer class="py-12 border-t border-slate-100 mt-20">
                <div class="max-w-7xl mx-auto px-4 text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Built with precision.
                </div>
            </footer>
        </div>
    </body>
</html>