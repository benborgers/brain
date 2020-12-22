@props(['icon', 'height' => 4])

<x-dynamic-component
    :component="'heroicon-' . $icon"
    class="h-{{ $height }} text-gray-500 hover:text-gray-800 duration-150 transition-colors focus:outline-none"
    {{ $attributes }}
/>
