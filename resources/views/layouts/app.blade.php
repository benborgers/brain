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

        @include('includes/frontend-variables')
        <script src="{{ mix('js/app.js') }}" defer></script>
        
        @livewireStyles

        @stack('head')
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-700">
        @auth
            <header class="bg-white shadow mb-12 flex items-center justify-between px-4 sm:px-8">
                <div class="flex items-center space-x-16">
                    <p class="text-gray-900 font-bold text-lg">Brain</p>

                    <div class="flex space-x-6 items-center">
                        @foreach ([
                            'Today' => route('today'),
                            'Tags' => route('tags'),
                            'Search' => route('search')
                        ] as $name => $url)
                            <a
                                href="{{ $url }}"
                                class="block py-5 font-medium border-b-2 border-transparent transition-colors duration-200 hover:text-gray-600 hover:border-gray-300
                                @if(request()->url() === $url) border-rose-500 text-rose-600 @else text-gray-500 @endif"
                                @if($name === 'Today')
                                    x-data
                                    :class="{ 'border-rose-500 text-rose-600': window.location.href === window.TODAY_ROUTE }"
                                @endif
                            >{{ $name }}</a>
                        @endforeach
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" value="Log out" class="bg-transparent text-gray-500 duration-150 hover:text-rose-600 cursor-pointer focus:outline-none" />
                </form>
            </header>

            <div class="mx-4 mb-16">
                <main class="max-w-screen-lg mx-auto">
                    @hasSection('title')
                        <div class="mb-6">
                            <h1 class="text-gray-900 text-2xl font-bold">@yield('title')</h1>
                        </div>
                    @endif
    
                    <div class="bg-white rounded-xl shadow p-8 pb-12">
                        {{ $slot }}
                    </div>

                    <p class="text-center mt-8 font-medium text-sm text-gray-300">Your memory is bad, but computer can help. </p>
                </main>
            </div>

            {{-- Privacy screen - activate by pressing shift twice --}}
            <div
                x-data="{ lastPress: 0, show: false }"
                x-on:keydown.window.shift="
                    const now = new Date().getTime()
                    if(now - lastPress < 200) {
                        show = !show
                    }
                    lastPress = now
                "
                x-init="$watch('show', value => {
                    if(value === true) {
                        document.body.classList.add('fixed', 'overflow-hidden')
                    } else {
                        document.body.classList.remove('fixed', 'overflow-hidden')
                    }
                })"
            >
                <div
                    x-cloak
                    x-show="show"
                    class="bg-black h-screen w-screen inset-0 absolute"
                ></div>
            </div>
        @endauth

        @guest
            {{ $slot }}
        @endguest

        @stack('modals')

        @livewireScripts
    </body>
</html>
