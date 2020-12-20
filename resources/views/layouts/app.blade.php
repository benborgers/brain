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

        <script src="{{ mix('js/app.js') }}" defer></script>

        @livewireStyles

        @stack('head')
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-700">
        @auth
            @sectionMissing('hide-sidebar')
                <div>
                    @livewire('sidebar')
                </div>
            @endif
           <main>
               {{ $slot }}
           </main>
        @endauth

        @guest
            {{ $slot }}
        @endguest

        @livewireScripts
    </body>
</html>
