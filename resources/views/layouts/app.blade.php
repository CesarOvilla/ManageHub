<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        // Prevenir parpadeo (flash) aplicando o removiendo dark mode antes del render
        const prefersDark = localStorage.getItem('dark_mode') === 'true';
        if (prefersDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Include the Quill library -->

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <!-- Include your favorite highlight.js stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
        rel="stylesheet">


    <tallstackui:script />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body x-data="sidebarLayout()" x-init="init()" x-cloak class="font-sans antialiased">
    <x-ts-dialog />
    <x-ts-toast />
    <x-banner />
    <div class="flex flex-col min-h-screen w-full">
        @include('components.navigation.sidebar')
        @include('components.navigation.header')

        <main
            :class="[
                'flex flex-auto flex-col pt-20 lg:pt-0 transition-all duration-300',
                isSidebarCollapsed ? 'lg:ps-20' : 'lg:ps-64',
                'bg-slate-100 text-slate-800 dark:bg-gray-950 dark:text-slate-200',
            ]">
            <div class="mx-auto w-full max-w-[90%] p-4 lg:p-8 ">
                {{ $slot }}
            </div>
        </main>

        @include('components.navigation.footer')
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
