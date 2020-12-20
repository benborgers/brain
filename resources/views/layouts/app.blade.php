<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @hasSection('title')
                @yield('title') —
            @endif
            Brain
        </title>
        <link rel="icon" href="https://emojicdn.elk.sh/🧠" />

        <style>[x-cloak] { display: none !important; }</style>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,600;0,700;0,800;0,900;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <script src="{{ mix('js/app.js') }}" defer></script>

        @livewireStyles

        @stack('head')
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-700">
        @auth
            <div
                @sectionmissing('hide-sidebar')
                    class="md:grid" style="grid-template-columns: 20rem 1fr"
                @endif
            >
                @sectionMissing('hide-sidebar')
                    <div class="border-r md:h-screen p-4 md:sticky top-0 left-0">
                        @livewire('sidebar')
                    </div>
                @endif
               <main class="p-4 md:p-6 w-full">
                   {{ $slot }}
               </main>
            </div>
        @endauth

        @guest
            {{ $slot }}
        @endguest

        @livewireScripts
    </body>
</html>
