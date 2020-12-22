<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 sm:mt-24">
    {{-- <div>
        {{ $logo }}
    </div> --}}

    <div class="mb-4">
        <h1 class="text-gray-900 font-extrabold text-2xl">@yield('title')</h1>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
