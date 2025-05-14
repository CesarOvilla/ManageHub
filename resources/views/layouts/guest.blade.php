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

    <tallstackui:script />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div
        class="flex min-h-screen w-screen items-center justify-center text-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-gray-200">
        <div class="relative">
            <!-- SVG decorativo arriba a la izquierda -->
            <div class="hidden sm:block h-56 w-56 text-indigo-300 dark:text-indigo-700 absolute z-10 -left-20 -top-20">
                <svg id="patternId" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="a" patternUnits="userSpaceOnUse" width="40" height="40"
                            patternTransform="scale(0.6) rotate(0)">
                            <rect x="0" y="0" width="100%" height="100%" fill="none" />
                            <path d="M11 6a5 5 0 01-5 5 5 5 0 01-5-5 5 5 0 015-5 5 5 0 015 5" stroke-width="1"
                                stroke="none" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="800%" height="800%" transform="translate(0,0)" fill="url(#a)" />
                </svg>
            </div>

            <!-- SVG decorativo abajo a la derecha -->
            <div
                class="hidden sm:block h-28 w-28 text-indigo-300 dark:text-indigo-700 absolute z-10 -right-20 -bottom-20">
                <svg id="patternId" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="b" patternUnits="userSpaceOnUse" width="40" height="40"
                            patternTransform="scale(0.5) rotate(0)">
                            <rect x="0" y="0" width="100%" height="100%" fill="none" />
                            <path d="M11 6a5 5 0 01-5 5 5 5 0 01-5-5 5 5 0 015-5 5 5 0 015 5" stroke-width="1"
                                stroke="none" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="800%" height="800%" transform="translate(0,0)" fill="url(#b)" />
                </svg>
            </div>

            <!-- Tarjeta de Registro -->
   
            <main>
                {{ $slot }}
            </main>
          
        </div>
    </div>
    @livewireScripts
</body>

</html>
