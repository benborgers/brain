@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border border-gray-200 p-2 transition-colors duration-150 focus:outline-none focus:ring ring-rose-100 focus:border-rose-300 rounded-md shadow-sm']) !!}
>
