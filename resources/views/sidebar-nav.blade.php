<div x-data="{ open: false }" class="relative">
    <x-heroicon-o-menu-alt-3
        class="h-5 text-gray-400 cursor-pointer duration-150 transition-colors hover:text-gray-700"
        x-on:click="open = !open"
    />

    <div
        x-show="open"
        x-on:click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="bg-white rounded-lg border border-gray-300 absolute top-6 right-0 origin-top-right shadow w-60 z-10 overflow-hidden divide-y divide-gray-100"
    >
        @foreach ([
            'Profile' => route('profile.show')
        ] as $name => $url)
            <a
                href="{{ $url }}"
                class="block text-gray-900 whitespace-nowrap hover:bg-gray-100 transition-colors duration-100 px-4 py-2
                    @if(url()->current() === $url) font-bold @endif"
            >
                {{ $name }}
            </a>
        @endforeach
    </div>
</div>
