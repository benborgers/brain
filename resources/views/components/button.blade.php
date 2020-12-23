@props(['as'])

<{{ $as }}
    {{ $attributes }}
    @if($as === 'input') type="submit" value="{{ $slot }}" @endif
    class="cursor-pointer whitespace-nowrap leading-none py-2 px-3 rounded-lg font-bold
        bg-rose-50 border border-rose-200 text-rose-500 hover:bg-rose-200 hover:text-rose-700 transition-colors duration-100"
>
    @if($as !== 'input') {{ $slot }} @endif
</{{ $as }}>
